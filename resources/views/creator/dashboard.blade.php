@extends('layouts.app')

@section('title', 'Creator Dashboard')

@section('content')
<div class="bc-page-header">
    <div>
        <h1 class="bc-page-title">Welcome back, {{ Auth::user()->name }}</h1>
        <p class="bc-page-subtitle">Here's what's happening with your campaigns.</p>
    </div>
    <div class="bc-flex">
        <a href="{{ route('campaigns.browse') }}" class="bc-btn bc-btn-primary">
            <i class="bi bi-search"></i> Browse Campaigns
        </a>
        <a href="{{ route('creator.applications') }}" class="bc-btn bc-btn-dark">
            <i class="bi bi-file-earmark-text"></i> My Applications
        </a>
    </div>
</div>

<div class="bc-grid-3" style="margin-bottom: 2rem;">
    <div class="bc-stat">
        <div class="bc-stat-icon bc-stat-icon-lime">
            <i class="bi bi-eye"></i>
        </div>
        <div>
            <span class="bc-stat-value">{{ $applications->pluck('campaign_id')->unique()->count() }}</span>
            <span class="bc-stat-label">Campaigns Browsed</span>
            <span class="bc-stat-sub">Unique campaigns explored</span>
        </div>
    </div>
    <div class="bc-stat">
        <div class="bc-stat-icon bc-stat-icon-purple">
            <i class="bi bi-send"></i>
        </div>
        <div>
            <span class="bc-stat-value">{{ $applications->count() }}</span>
            <span class="bc-stat-label">Applications Sent</span>
            <span class="bc-stat-sub">{{ $applications->where('status', 'pending')->count() }} pending, {{ $applications->where('status', 'accepted')->count() }} accepted</span>
        </div>
    </div>
    <div class="bc-stat">
        <div class="bc-stat-icon bc-stat-icon-ink">
            <i class="bi bi-chat-dots"></i>
        </div>
        <div>
            <span class="bc-stat-value">{{ $unreadCount }}</span>
            <span class="bc-stat-label">Unread messages</span>
            <span class="bc-stat-sub">Needs your attention</span>
        </div>
    </div>
</div>

<div class="bc-grid-2">
    <div class="bc-card">
        <div class="bc-card-header">
            <h2 class="bc-card-title">Recent Applications</h2>
            <a href="{{ route('creator.applications') }}" class="bc-btn bc-btn-sm bc-btn-ghost">View All</a>
        </div>
        @if($applications->isEmpty())
            <div class="bc-empty">
                <div class="bc-empty-icon">
                    <i class="bi bi-file-earmark-text" style="font-size: 2rem;"></i>
                </div>
                <p class="bc-empty-text">No applications yet</p>
                <p class="bc-empty-sub">Start by browsing open campaigns that match your niche.</p>
                <a href="{{ route('campaigns.browse') }}" class="bc-btn bc-btn-primary" style="margin-top: 1rem;">
                    <i class="bi bi-search"></i> Browse Campaigns
                </a>
            </div>
        @else
            <div class="bc-list">
                @foreach($applications->take(5) as $application)
                    <a href="{{ route('campaigns.show', $application->campaign) }}" class="bc-list-item">
                        <div>
                            <div class="bc-list-item-title">{{ $application->campaign->title ?? 'Campaign' }}</div>
                            <div class="bc-list-item-sub">
                                <span class="bc-badge bc-badge-{{ $application->status }}">{{ ucfirst($application->status) }}</span>
                                &middot; Applied {{ $application->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <i class="bi bi-chevron-right" style="color: var(--muted); font-size: 0.875rem;"></i>
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
                <div class="bc-empty-icon">
                    <i class="bi bi-chat-dots" style="font-size: 2rem;"></i>
                </div>
                <p class="bc-empty-text">No messages yet</p>
                <p class="bc-empty-sub">When brands reach out about your applications, messages will appear here.</p>
            </div>
        @else
            <div class="bc-list">
                @foreach($messages->take(5) as $message)
                    <a href="{{ route('messages.conversation', $message->sender) }}" class="bc-list-item">
                        <div>
                            <div class="bc-list-item-title">{{ $message->sender->name ?? 'Brand' }}</div>
                            <div class="bc-list-item-sub">{{ Str::limit($message->message, 80) }}</div>
                        </div>
                        <i class="bi bi-chevron-right" style="color: var(--muted); font-size: 0.875rem;"></i>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>

@if($campaigns->isNotEmpty())
<div style="margin-top: 2rem;">
    <div class="bc-card">
        <div class="bc-card-header">
            <h2 class="bc-card-title">Open Campaigns</h2>
            <a href="{{ route('campaigns.browse') }}" class="bc-btn bc-btn-sm bc-btn-ghost">Browse All</a>
        </div>
        <div class="bc-grid-2" style="padding: 0;">
            @foreach($campaigns as $campaign)
                <a href="{{ route('campaigns.show', $campaign) }}" class="bc-campaign-card">
                    <div class="bc-campaign-card-body">
                        <div class="bc-campaign-card-title">{{ $campaign->title }}</div>
                        <div class="bc-campaign-card-meta">
                            <span><i class="bi bi-building"></i> {{ $campaign->brand->name ?? 'Brand' }}</span>
                            <span><i class="bi bi-currency-dollar"></i> {{ $campaign->budget !== null ? 'Rs. ' . number_format($campaign->budget, 0) : 'Budget TBD' }}</span>
                            @if($campaign->category)
                                <span class="bc-badge bc-badge-open">{{ $campaign->category->name }}</span>
                            @endif
                        </div>
                        @if($campaign->description)
                            <div class="bc-campaign-card-desc">{{ Str::limit($campaign->description, 120) }}</div>
                        @endif
                    </div>
                    <div class="bc-campaign-card-footer">
                        <span>Deadline: {{ $campaign->deadline ? \Carbon\Carbon::parse($campaign->deadline)->format('M d, Y') : 'Flexible' }}</span>
                        <span style="font-weight:700;color:var(--purple);font-size:13px;">View &amp; Apply →</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@else
<div class="bc-card" style="margin-top: 2rem;">
    <div class="bc-empty">
        <div class="bc-empty-icon">
            <i class="bi bi-search" style="font-size: 2rem;"></i>
        </div>
        <p class="bc-empty-text">No open campaigns right now</p>
        <p class="bc-empty-sub">New opportunities appear here — check back soon.</p>
    </div>
</div>
@endif
@endsection
