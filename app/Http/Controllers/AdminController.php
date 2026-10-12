<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignApplication;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (! Auth::user()->isAdmin()) {
                abort(403);
            }

            return $next($request);
        });
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_creators' => User::where('role', 'creator')->count(),
            'total_brands' => User::where('role', 'brand')->count(),
            'total_campaigns' => Campaign::count(),
            'total_applications' => CampaignApplication::count(),
            'pending_applications' => CampaignApplication::where('status', 'pending')->count(),
        ];

        $recent_users = User::latest()->take(10)->get();
        $recent_campaigns = Campaign::with('brand')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_campaigns'));
    }

    public function users()
    {
        $users = User::with('creatorProfile', 'brandProfile')
            ->latest()
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', 'User status updated successfully.');
    }

    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete admin users.');
        }
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    public function campaigns()
    {
        $campaigns = Campaign::with('brand', 'category', 'applications')
            ->latest()
            ->paginate(20);

        return view('admin.campaigns', compact('campaigns'));
    }

    public function deleteCampaign(Campaign $campaign)
    {
        $campaign->delete();

        return back()->with('success', 'Campaign deleted successfully.');
    }

    public function categories()
    {
        $categories = Category::withCount('creatorProfiles', 'campaigns')->get();

        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create($data);

        return back()->with('success', 'Category created successfully.');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}
