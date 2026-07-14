@extends('layouts.app')

@section('title', 'Creator Dashboard')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Creator Dashboard</h1>
</div>

<div class="bc-grid-3" style="margin-bottom: 2rem;">
    <div class="bc-stat bc-stat-lime">
        <span class="bc-stat-label">Campaigns Browsed</span>
        <span class="bc-stat-value">{{ $applications->pluck('campaign_id')->unique()->count() }}</span>
        <span class="bc-stat-sub">Campaigns explored</span>
    </div>
    <div class="bc-stat bc-stat-purple">
        <span class="bc-stat-label">Applications Sent</span>
        <span class="bc-stat-value">{{ $applications->count() }}</span>
        <span class="bc-stat-sub">Pending &amp; completed</span>
    </div>
    <div class="bc-stat bc-stat-dark">
        <span class="bc-stat-label">Messages</span>
        <span class="bc-stat-value">{{ $messages->count() }}</span>
        <span class="bc-stat-sub">Conversations</span>
    </div>
</div>

<div class="bc-grid-2">
    <div class="bc-card">
        <div class="bc-card-header">
            <h2 class="bc-card-title">Recent Applications</h2>
            <a href="{{ route('creator.applications.index') }}" class="bc-btn bc-btn-sm bc-btn-ghost">View All</a>
        </div>
        @if($applications->isEmpty())
            <div class="bc-empty">
                <div class="bc-empty-icon">&#128196;</div>
                <p class="bc-empty-text">No applications yet</p>
                <p class="bc-empty-sub">Browse campaigns and send your first application.</p>
            </div>
        @else
            <div class="bc-list">
                @foreach($applications->take(5) as $application)
                    <a href="{{ route('campaigns.show', $application->campaign) }}" class="bc-list-item" style="text-decoration: none; color: inherit;">
                        <div>
                            <div class="bc-list-item-title">{{ $application->campaign->title ?? 'Campaign' }}</div>
                            <div class="bc-list-item-sub">
                                <span class="bc-badge bc-badge-{{ $application->status }}">{{ ucfirst($application->status) }}</span>
                                &middot; Applied {{ $application->created_at->diffForHumans() }}
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
        </div>
        @if($messages->isEmpty())
            <div class="bc-empty">
                <div class="bc-empty-icon">&#128172;</div>
                <p class="bc-empty-text">No messages yet</p>
                <p class="bc-empty-sub">Messages from brands will appear here.</p>
            </div>
        @else
            <div class="bc-list">
                @foreach($messages->take(5) as $message)
                    <div class="bc-list-item">
                        <div>
                            <div class="bc-list-item-title">{{ $message->sender->name ?? 'Brand' }}</div>
                            <div class="bc-list-item-sub">{{ Str::limit($message->body, 80) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
