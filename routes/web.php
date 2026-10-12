<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandProfileController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CreatorProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliverableController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReviewController;
use App\Models\Campaign;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Creator Profile
    Route::get('/creator/profile', [CreatorProfileController::class, 'edit'])->name('creator.profile');
    Route::put('/creator/profile', [CreatorProfileController::class, 'update'])->name('creator.profile.update');

    // Brand Profile
    Route::get('/brand/profile', [BrandProfileController::class, 'edit'])->name('brand.profile');
    Route::put('/brand/profile', [BrandProfileController::class, 'update'])->name('brand.profile.update');

    // Campaigns
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/browse', [CampaignController::class, 'browse'])->name('campaigns.browse');
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');
    Route::get('/campaigns/{campaign}/edit', [CampaignController::class, 'edit'])->name('campaigns.edit');
    Route::put('/campaigns/{campaign}', [CampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');

    // Brand's own campaigns
    Route::get('/my-campaigns', [CampaignController::class, 'myCampaigns'])->name('brand.campaigns');

    // Campaign Applications
    Route::post('/campaigns/{campaign}/apply', [ApplicationController::class, 'apply'])->name('campaigns.apply');
    Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('creator.applications');
    Route::get('/campaigns/{campaign}/applications', [ApplicationController::class, 'manage'])->name('brand.applications');
    Route::post('/campaigns/{campaign}/applications/{application}/status', [ApplicationController::class, 'updateStatus'])
        ->name('applications.update-status');

    // Messages
    Route::get('/messages/inbox', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/sent', [MessageController::class, 'sent'])->name('messages.sent');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::get('/messages/conversation/{user}', [MessageController::class, 'conversation'])->name('messages.conversation');

    // Deliverables
    Route::get('/deliverables', [DeliverableController::class, 'index'])->name('deliverables.index');

    // Reviews
    Route::get('/campaigns/{campaign}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/campaigns/{campaign}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{user}', [ReviewController::class, 'show'])->name('reviews.show');

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
        Route::post('/users/{user}/delete', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::get('/campaigns', [AdminController::class, 'campaigns'])->name('admin.campaigns');
        Route::post('/campaigns/{campaign}/delete', [AdminController::class, 'deleteCampaign'])->name('admin.campaigns.delete');
        Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
        Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        Route::post('/categories/{category}/delete', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');
    });
});

// AI Chat Assistant (works for both guests and authenticated users)
Route::post('/ai/chat', [AiController::class, 'chat'])->name('ai.chat');

// Landing page
Route::get('/', function () {
    $openWork = Campaign::with('brand', 'category')
        ->where('status', 'open')
        ->latest()
        ->take(6)
        ->get();

    return view('landing', compact('openWork'));
});
