<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        return view('reviews.create', compact('campaign'));
    }

    public function store(Request $request, Campaign $campaign)
    {
        $data = $request->validate([
            'reviewee_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $existing = Review::where('reviewer_id', Auth::id())
            ->where('reviewee_id', $data['reviewee_id'])
            ->where('campaign_id', $campaign->id)
            ->exists();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this user for this campaign.');
        }

        $data['reviewer_id'] = Auth::id();
        $data['campaign_id'] = $campaign->id;

        Review::create($data);

        return redirect()->route('campaigns.show', $campaign)->with('success', 'Review submitted successfully.');
    }

    public function show(User $user)
    {
        $reviews = Review::where('reviewee_id', $user->id)
            ->with('reviewer', 'campaign')
            ->latest()
            ->get();

        $averageRating = $reviews->avg('rating');

        return view('reviews.show', compact('reviews', 'averageRating', 'user'));
    }
}
