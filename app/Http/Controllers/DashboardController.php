<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\Message;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        if ($user->isBrand()) {
            return $this->brandDashboard($user);
        }

        return $this->creatorDashboard($user);
    }

    private function adminDashboard()
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_creators' => \App\Models\User::where('role', 'creator')->count(),
            'total_brands' => \App\Models\User::where('role', 'brand')->count(),
            'total_campaigns' => Campaign::count(),
            'total_applications' => CampaignApplication::count(),
        ];

        $recent_users = \App\Models\User::latest()->take(5)->get();
        $recent_campaigns = Campaign::with('brand')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_campaigns'));
    }

    private function brandDashboard($user)
    {
        $campaigns = Campaign::where('brand_id', $user->id)->latest()->get();
        $applications = CampaignApplication::whereIn('campaign_id', $campaigns->pluck('id'))->latest()->take(10)->get();
        $messages = Message::where('receiver_id', $user->id)->latest()->take(5)->get();
        $profile = $user->brandProfile;

        return view('brand.dashboard', compact('campaigns', 'applications', 'messages', 'profile'));
    }

    private function creatorDashboard($user)
    {
        $applications = CampaignApplication::where('creator_id', $user->id)->with('campaign')->latest()->get();
        $campaigns = Campaign::where('status', 'open')->latest()->take(10)->get();
        $messages = Message::where('receiver_id', $user->id)->latest()->take(5)->get();
        $profile = $user->creatorProfile;

        return view('creator.dashboard', compact('applications', 'campaigns', 'messages', 'profile'));
    }
}
