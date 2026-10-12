<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request, Campaign $campaign)
    {
        $this->ensureParticipant($campaign);

        $reviewee = null;
        if ($request->query('for')) {
            $reviewee = User::findOrFail($request->query('for'));
            abort_unless($this->isValidReviewee($campaign, (int) $reviewee->id), 403);
        }

        return view('reviews.create', compact('campaign', 'reviewee'));
    }

    public function store(Request $request, Campaign $campaign)
    {
        $data = $request->validate([
            'reviewee_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        if (! $this->isValidReviewee($campaign, (int) $data['reviewee_id'])) {
            return back()->with('error', 'You can only review the brand or an accepted creator on this campaign.');
        }

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

    private function ensureParticipant(Campaign $campaign): void
    {
        $user = Auth::user();
        $ok = $user->id === $campaign->brand_id
            || CampaignApplication::where('campaign_id', $campaign->id)
                ->where('creator_id', $user->id)
                ->where('status', 'accepted')->exists();
        abort_unless($ok, 403);
    }

    private function isValidReviewee(Campaign $campaign, int $revieweeId): bool
    {
        if ($revieweeId === Auth::id()) {
            return false;
        }

        return $revieweeId === $campaign->brand_id
            || CampaignApplication::where('campaign_id', $campaign->id)
                ->where('creator_id', $revieweeId)
                ->where('status', 'accepted')->exists();
    }
}
