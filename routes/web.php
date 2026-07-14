<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CreatorProfileController;
use App\Http\Controllers\BrandProfileController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Creator Profile
    Route::get('/creator/profile', [CreatorProfileController::class, 'edit'])->name('creator.profile');
    Route::post('/creator/profile', [CreatorProfileController::class, 'update'])->name('creator.profile.update');

    // Brand Profile
    Route::get('/brand/profile', [BrandProfileController::class, 'edit'])->name('brand.profile');
    Route::post('/brand/profile', [BrandProfileController::class, 'update'])->name('brand.profile.update');

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

    // Reviews
    Route::post('/campaigns/{campaign}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{user}', [App\Http\Controllers\ReviewController::class, 'show'])->name('reviews.show');

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

// Landing page
Route::get('/', function () {
    return view('landing');
});

// Employee CRUD (existing)

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
