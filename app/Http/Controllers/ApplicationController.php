<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function apply(Request $request, Campaign $campaign)
    {
        if (!Auth::user()->isCreator()) {
            abort(403);
        }

        if ($campaign->status !== 'open') {
            return back()->with('error', 'This campaign is no longer accepting applications.');
        }

        $exists = CampaignApplication::where('campaign_id', $campaign->id)
            ->where('creator_id', Auth::id())
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already applied for this campaign.');
        }

        $data = $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        CampaignApplication::create([
            'campaign_id' => $campaign->id,
            'creator_id' => Auth::id(),
            'message' => $data['message'] ?? null,
        ]);

        return back()->with('success', 'Application submitted successfully.');
    }

    public function myApplications()
    {
        if (!Auth::user()->isCreator()) {
            abort(403);
        }

        $applications = CampaignApplication::where('creator_id', Auth::id())
            ->with('campaign.brand.brandProfile')
            ->latest()
            ->get();

        return view('creator.applications', compact('applications'));
    }

    public function manage(Campaign $campaign)
    {
        if (!Auth::user()->isBrand() || $campaign->brand_id !== Auth::id()) {
            abort(403);
        }

        $applications = CampaignApplication::where('campaign_id', $campaign->id)
            ->with('creator.creatorProfile')
            ->latest()
            ->get();

        return view('brand.applications', compact('campaign', 'applications'));
    }

    public function updateStatus(Request $request, Campaign $campaign, CampaignApplication $application)
    {
        if (!Auth::user()->isBrand() || $campaign->brand_id !== Auth::id()) {
            abort(403);
        }

        if ($application->campaign_id !== $campaign->id) {
            abort(404);
        }

        $data = $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $application->update(['status' => $data['status']]);

        $allStatuses = $campaign->applications()->pluck('status');
        if ($data['status'] === 'accepted') {
            $campaign->update(['status' => 'in_progress']);
        }

        return back()->with('success', 'Application status updated successfully.');
    }
}
