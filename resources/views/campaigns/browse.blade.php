@extends('layouts.app')

@section('title', 'Browse Campaigns')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Browse Campaigns</h1>
    <p style="color:var(--bc-text-muted);margin-top:.25rem;">Find campaigns that match your skills and apply.</p>
</div>

@if($campaigns->isEmpty())
    <div class="bc-empty">
        <div class="bc-empty-icon">
            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <p class="bc-empty-text">No campaigns available</p>
        <p class="bc-empty-sub">Check back later for new opportunities.</p>
    </div>
@else
    <div class="bc-grid-3" style="gap:1.5rem;">
        @foreach($campaigns as $campaign)
            <div class="bc-card">
                <div class="bc-card-header">
                    <div class="bc-flex" style="justify-content:space-between;align-items:start;">
                        <h3 class="bc-card-title">{{ $campaign->title }}</h3>
                        @if($campaign->status === 'open')
                            <span class="bc-badge bc-badge-open">Open</span>
                        @endif
                    </div>
                    <p style="color:var(--bc-text-muted);font-size:.875rem;margin-top:.25rem;">
                        {{ $campaign->brand->name ?? 'Brand' }}
                    </p>
                </div>
                <div class="bc-divider"></div>
                <div class="bc-list">
                    <div class="bc-list-item" style="padding:.5rem 0;">
                        <span class="bc-list-item-sub">Budget</span>
                        <span class="bc-list-item-title">Rs. {{ number_format($campaign->budget, 2) }}</span>
                    </div>
                    <div class="bc-list-item" style="padding:.5rem 0;">
                        <span class="bc-list-item-sub">Deadline</span>
                        <span class="bc-list-item-title">{{ \Carbon\Carbon::parse($campaign->deadline)->format('M d, Y') }}</span>
                    </div>
                    <div class="bc-list-item" style="padding:.5rem 0;">
                        <span class="bc-list-item-sub">Category</span>
                        <span class="bc-list-item-title">{{ $campaign->category->name ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="bc-divider"></div>
                <div class="bc-flex" style="justify-content:space-between;align-items:center;">
                    <a href="{{ route('campaigns.show', $campaign) }}" class="bc-btn bc-btn-ghost bc-btn-sm">View Details</a>
                    <a href="{{ route('campaigns.show', $campaign) }}" class="bc-btn bc-btn-primary bc-btn-sm">Apply Now</a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bc-pagination" style="margin-top:2rem;">
        {{ $campaigns->links() }}
    </div>
@endif
@endsection
