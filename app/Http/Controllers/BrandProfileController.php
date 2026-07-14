<?php

namespace App\Http\Controllers;

use App\Models\BrandProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isBrand()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function edit()
    {
        $profile = Auth::user()->brandProfile;
        return view('brand.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $profile = Auth::user()->brandProfile;
        if ($profile) {
            $profile->update($data);
        } else {
            $data['user_id'] = Auth::id();
            BrandProfile::create($data);
        }

        return redirect()->route('brand.profile')->with('success', 'Brand profile updated successfully.');
    }
}
