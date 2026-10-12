@extends('layouts.app')

@section('title', 'Brand Dashboard')

@section('content')
<div class="bc-page-header bc-flex" style="justify-content: space-between; align-items: center;">
    <h1 class="bc-page-title">Brand Dashboard</h1>
    <div class="bc-flex" style="gap: 0.5rem;">
        <a href="{{ route('brand.profile') }}" class="bc-btn bc-btn-ghost">Company Profile</a>
        <a href="{{ route('campaigns.create') }}" class="bc-btn bc-btn-primary">New Campaign</a>
    </div>
</div>

@if(!$profile)
    <div class="bc-alert bc-alert-warning" style="margin-bottom: 1.5rem;">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>
            <strong>Attention:</strong> Please complete your company profile before creating campaigns.
            <a href="{{ route('brand.profile') }}" class="bc-btn bc-btn-sm bc-btn-primary" style="margin-left: 0.5rem;">Complete Profile</a>
        </div>
    </div>
@endif

<div class="bc-grid-3" style="margin-bottom: 2rem;">
    <div class="bc-stat">
        <div class="bc-stat-icon bc-stat-icon-lime">
            <i class="bi bi-megaphone"></i>
        </div>
        <div>
            <span class="bc-stat-value">{{ $campaigns->count() }}</span>
            <span class="bc-stat-label">Total Campaigns</span>
            <span class="bc-stat-sub">Active &amp; completed</span>
        </div>
    </div>
    <div class="bc-stat">
        <div class="bc-stat-icon bc-stat-icon-purple">
            <i class="bi bi-file-earmark-text"></i>
        </div>
        <div>
            <span class="bc-stat-value">{{ $applicationCount }}</span>
            <span class="bc-stat-label">Applications Received</span>
            <span class="bc-stat-sub">Across all campaigns</span>
        </div>
    </div>
    <div class="bc-stat">
        <div class="bc-stat-icon bc-stat-icon-ink">
            <i class="bi bi-chat-dots"></i>
        </div>
        <div>
            <span class="bc-stat-value">{{ $messageCount }}</span>
            <span class="bc-stat-label">Messages</span>
            <span class="bc-stat-sub">Conversations</span>
        </div>
    </div>
</div>

<div class="bc-grid-2">
    <div class="bc-card">
        <div class="bc-card-header">
            <h2 class="bc-card-title">Recent Campaigns</h2>
            <a href="{{ route('brand.campaigns') }}" class="bc-btn bc-btn-sm bc-btn-ghost">View All</a>
        </div>
        @if($campaigns->isEmpty())
            <div class="bc-empty">
                <div class="bc-empty-icon">&#128196;</div>
                <p class="bc-empty-text">No campaigns yet</p>
                <p class="bc-empty-sub">Create your first campaign to start collaborating with creators.</p>
                <a href="{{ route('campaigns.create') }}" class="bc-btn bc-btn-primary" style="margin-top: 1rem;">New Campaign</a>
            </div>
        @else
            <div class="bc-list">
                @foreach($campaigns->take(5) as $campaign)
                    <a href="{{ route('campaigns.show', $campaign) }}" class="bc-list-item" style="text-decoration: none; color: inherit;">
                        <div>
                            <div class="bc-list-item-title">{{ $campaign->title }}</div>
                            <div class="bc-list-item-sub">
                                <span class="bc-badge bc-badge-{{ $campaign->status }}">{{ ucfirst($campaign->status) }}</span>
                                &middot; {{ $campaign->applications_count ?? $campaign->applications->count() }} applications
                                &middot; Budget: {{ $campaign->budget !== null ? 'Rs. ' . number_format($campaign->budget, 2) : 'Not specified' }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="bc-card">
        <div class="bc-card-header">
            <h2 class="bc-card-title">Recent Messages</h2>
            <a href="{{ route('messages.inbox') }}" class="bc-btn bc-btn-sm bc-btn-ghost">View All</a>
        </div>
        @if($messages->isEmpty())
            <div class="bc-empty">
                <div class="bc-empty-icon">&#128172;</div>
                <p class="bc-empty-text">No messages yet</p>
                <p class="bc-empty-sub">Messages from creators will appear here.</p>
                <a href="{{ route('messages.inbox') }}" class="bc-btn bc-btn-primary" style="margin-top: 1rem;">Go to Inbox</a>
            </div>
        @else
            <div class="bc-list">
                @foreach($messages->take(5) as $message)
                    <a href="{{ route('messages.conversation', $message->sender) }}" class="bc-list-item" style="text-decoration: none; color: inherit;">
                        <div>
                            <div class="bc-list-item-title">{{ $message->sender->name ?? 'Unknown' }}</div>
                            <div class="bc-list-item-sub">{{ Str::limit($message->message, 80) }}</div>
                        </div>
                        <i class="bi bi-chevron-right" style="color: var(--muted); font-size: 0.875rem;"></i>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
