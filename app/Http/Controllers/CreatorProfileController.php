<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CreatorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreatorProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (! Auth::user()->isCreator()) {
                abort(403);
            }

            return $next($request);
        });
    }

    public function edit()
    {
        $profile = Auth::user()->creatorProfile;
        $categories = Category::all();

        return view('creator.profile', compact('profile', 'categories'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'niche' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'social_media_platform' => 'nullable|string|max:255',
            'social_media_link' => 'nullable|url|max:255',
            'follower_count' => 'nullable|integer|min:0',
            'engagement_rate' => 'nullable|numeric|min:0|max:100',
            'portfolio' => 'nullable|string',
            'price_per_post' => 'nullable|numeric|min:0',
            'audience_details' => 'nullable|string',
            'availability' => 'nullable|in:available,busy,unavailable',
        ]);

        $profile = Auth::user()->creatorProfile;
        if ($profile) {
            $profile->update($data);
        } else {
            $data['user_id'] = Auth::id();
            CreatorProfile::create($data);
        }

        return redirect()->route('creator.profile')->with('success', 'Profile updated successfully.');
    }
}
