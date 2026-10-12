<?php

namespace App\Http\Controllers;

use App\Models\CampaignApplication;
use Illuminate\Support\Facades\Auth;

class DeliverableController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isCreator()) {
            $deliverables = CampaignApplication::where('creator_id', $user->id)
                ->where('status', 'accepted')
                ->with('campaign.brand.brandProfile')
                ->latest()
                ->get();

            return view('deliverables.index', compact('deliverables'));
        }

        if ($user->isBrand()) {
            $deliverables = CampaignApplication::whereHas('campaign', function ($q) use ($user) {
                $q->where('brand_id', $user->id);
            })->where('status', 'accepted')
                ->with('campaign', 'creator.creatorProfile')
                ->latest()
                ->get();

            return view('deliverables.index', compact('deliverables'));
        }

        abort(403);
    }
}
