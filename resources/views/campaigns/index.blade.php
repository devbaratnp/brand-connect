@extends('layouts.app')

@section('title', 'All Campaigns')

@section('content')
<div class="bc-page-header bc-flex" style="justify-content:space-between;align-items:center;">
    <h1 class="bc-page-title">All Campaigns</h1>
    <a href="{{ route('campaigns.create') }}" class="bc-btn bc-btn-primary">Post Campaign</a>
</div>

@if($campaigns->isEmpty())
    <div class="bc-empty">
        <div class="bc-empty-icon">
            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2z"/><path d="M9 12h6m-6 4h6m-6-8h6"/></svg>
        </div>
        <p class="bc-empty-text">No campaigns yet</p>
        <p class="bc-empty-sub">Create your first campaign to get started.</p>
        <a href="{{ route('campaigns.create') }}" class="bc-btn bc-btn-primary" style="margin-top:1rem;">Post Campaign</a>
    </div>
@else
    <div class="bc-grid-2" style="gap:1.5rem;">
        @foreach($campaigns as $campaign)
            <a href="{{ route('campaigns.show', $campaign) }}" style="text-decoration:none;color:inherit;">
                <div class="bc-card">
                    <div class="bc-card-header bc-flex" style="justify-content:space-between;align-items:start;">
                        <div>
                            <h3 class="bc-card-title">{{ $campaign->title }}</h3>
                            <p style="color:var(--bc-text-muted);font-size:.875rem;margin-top:.25rem;">{{ $campaign->brand->name ?? 'Brand' }}</p>
                        </div>
                        @if($campaign->status === 'open')
                            <span class="bc-badge bc-badge-open">Open</span>
                        @elseif($campaign->status === 'in_progress')
                            <span class="bc-badge bc-badge-progress">In Progress</span>
                        @elseif($campaign->status === 'closed')
                            <span class="bc-badge bc-badge-closed">Closed</span>
                        @else
                            <span class="bc-badge bc-badge-pending">{{ ucfirst($campaign->status) }}</span>
                        @endif
                    </div>
                    <div class="bc-divider"></div>
                    <div class="bc-flex" style="justify-content:space-between;align-items:center;">
                        <span style="font-size:1.1rem;font-weight:600;">Rs. {{ number_format($campaign->budget, 2) }}</span>
                        <span style="color:var(--bc-text-muted);font-size:.875rem;">
                            {{ $campaign->applications_count ?? $campaign->applications->count() }} applications
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <div class="bc-pagination" style="margin-top:2rem;">
        {{ $campaigns->links() }}
    </div>
@endif
@endsection
