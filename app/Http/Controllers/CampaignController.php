<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with('brand', 'category')
            ->latest()
            ->paginate(12);
        return view('campaigns.index', compact('campaigns'));
    }

    public function show(Campaign $campaign)
    {
        $campaign->load('brand.brandProfile', 'category', 'applications.creator');
        $hasApplied = Auth::check() && Auth::user()->isCreator()
            ? $campaign->applications()->where('creator_id', Auth::id())->exists()
            : false;
        return view('campaigns.show', compact('campaign', 'hasApplied'));
    }

    public function create()
    {
        $this->authorizeBrand();
        $categories = Category::all();
        return view('campaigns.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorizeBrand();

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'budget' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date|after:today',
            'requirements' => 'nullable|string',
        ]);

        $data['brand_id'] = Auth::id();
        $data['status'] = 'open';

        Campaign::create($data);

        return redirect()->route('brand.campaigns')->with('success', 'Campaign created successfully.');
    }

    public function edit(Campaign $campaign)
    {
        $this->authorizeBrand();
        $this->authorizeOwner($campaign);

        $categories = Category::all();
        return view('campaigns.edit', compact('campaign', 'categories'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->authorizeBrand();
        $this->authorizeOwner($campaign);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'budget' => 'nullable|numeric|min:0',
            'deadline' => 'nullable|date',
            'requirements' => 'nullable|string',
            'status' => 'nullable|in:open,closed,cancelled',
        ]);

        $campaign->update($data);

        return redirect()->route('brand.campaigns')->with('success', 'Campaign updated successfully.');
    }

    public function destroy(Campaign $campaign)
    {
        $this->authorizeBrand();
        $this->authorizeOwner($campaign);

        $campaign->delete();

        return redirect()->route('brand.campaigns')->with('success', 'Campaign deleted successfully.');
    }

    public function myCampaigns()
    {
        $this->authorizeBrand();
        $campaigns = Campaign::where('brand_id', Auth::id())
            ->with('applications')
            ->latest()
            ->get();
        return view('brand.campaigns', compact('campaigns'));
    }

    public function browse()
    {
        $campaigns = Campaign::where('status', 'open')
            ->with('brand.brandProfile', 'category')
            ->latest()
            ->paginate(12);
        return view('campaigns.browse', compact('campaigns'));
    }

    protected function authorizeBrand(): void
    {
        if (!Auth::user()->isBrand()) {
            abort(403);
        }
    }

    protected function authorizeOwner(Campaign $campaign): void
    {
        if ($campaign->brand_id !== Auth::id()) {
            abort(403);
        }
    }
}
