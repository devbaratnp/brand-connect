<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationReceivedMail;
use App\Mail\ApplicationStatusChangedMail;
use App\Models\Campaign;
use App\Models\CampaignApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function apply(Request $request, Campaign $campaign)
    {
        if (! Auth::user()->isCreator()) {
            abort(403);
        }

        if ($campaign->status !== 'open') {
            return back()->with('error', 'This campaign is no longer accepting applications.');
        }

        $exists = CampaignApplication::where('campaign_id', $campaign->id)
            ->where('creator_id', Auth::id())
            ->exists();

        if ($exists) {
            return redirect()->route('creator.applications')->with('error', 'You have already applied for this campaign. You can track it below.');
        }

        $data = $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        CampaignApplication::create([
            'campaign_id' => $campaign->id,
            'creator_id' => Auth::id(),
            'message' => $data['message'] ?? null,
        ]);

        Mail::to($campaign->brand->email)->send(new ApplicationReceivedMail(
            CampaignApplication::where('campaign_id', $campaign->id)->where('creator_id', Auth::id())->first(),
            $campaign
        ));

        return back()->with('success', 'Application submitted successfully.');
    }

    public function myApplications()
    {
        if (! Auth::user()->isCreator()) {
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
        if (! Auth::user()->isBrand() || $campaign->brand_id !== Auth::id()) {
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
        if (! Auth::user()->isBrand() || $campaign->brand_id !== Auth::id()) {
            abort(403);
        }

        if ($application->campaign_id !== $campaign->id) {
            abort(404);
        }

        $data = $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $application->update(['status' => $data['status']]);

        Mail::to($application->creator->email)->send(new ApplicationStatusChangedMail(
            $application,
            $campaign,
            $data['status']
        ));

        if ($data['status'] === 'accepted') {
            $campaign->update(['status' => 'in_progress']);
        } elseif ($campaign->status === 'in_progress'
            && ! $campaign->applications()->where('status', 'accepted')->exists()) {
            $campaign->update(['status' => 'open']);
        }

        return back()->with('success', 'Application status updated successfully.');
    }
}
