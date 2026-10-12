@extends('layouts.app')

@section('title', 'Manage Applications')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Applications for {{ $campaign->title }}</h1>
    <a href="{{ route('campaigns.show', $campaign) }}" class="bc-btn bc-btn-ghost" style="margin-top: 0.5rem;">Back to Campaign</a>
</div>

@if($applications->isEmpty())
    <div class="bc-card">
        <div class="bc-empty">
            <div class="bc-empty-icon">&#128101;</div>
            <p class="bc-empty-text">No applications yet</p>
            <p class="bc-empty-sub">Creators will apply to your campaign. Check back soon.</p>
            <a href="{{ route('campaigns.show', $campaign) }}" class="bc-btn bc-btn-ghost" style="margin-top: 1rem;">Back to Campaign</a>
        </div>
    </div>
@else
    <div class="bc-list">
        @foreach($applications as $application)
            <div class="bc-list-item" style="align-items: flex-start;">
                <div style="flex: 1;">
                    <div class="bc-list-item-title">{{ $application->creator->name ?? 'Unknown Creator' }}</div>
                    <div class="bc-list-item-sub">
                        Applied {{ $application->created_at->diffForHumans() }}
                        &middot; Status: <span class="bc-badge bc-badge-{{ $application->status }}">{{ ucfirst($application->status) }}</span>
                    </div>
                    @if($application->message)
                        <p style="margin-top: 0.75rem; color: var(--ink); line-height: 1.6;">{{ $application->message }}</p>
                    @endif
                </div>

                @if($application->status === 'pending')
                    <div class="bc-flex" style="gap: 0.5rem; margin-top: 0.5rem;">
                        <form method="POST" action="{{ route('applications.update-status', [$campaign, $application]) }}">
                            @csrf
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit" class="bc-btn bc-btn-sm bc-btn-success" aria-label="Accept application from {{ $application->creator->name ?? 'creator' }}">Accept</button>
                        </form>
                        <form method="POST" action="{{ route('applications.update-status', [$campaign, $application]) }}" onsubmit="return confirm('Reject this application? The creator will be notified.');">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="bc-btn bc-btn-sm bc-btn-danger" aria-label="Reject application from {{ $application->creator->name ?? 'creator' }}">Reject</button>
                        </form>
                    </div>
                    @error('status')
                        <p class="bc-error" style="margin-top:.5rem;">{{ $message }}</p>
                    @enderror
                @endif
                @if($application->status === 'accepted')
                    <div style="margin-top: 0.5rem;">
                        <a href="{{ route('reviews.create', $campaign) }}?for={{ $application->creator_id }}" class="bc-btn bc-btn-sm bc-btn-ghost">Leave Review</a>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif
@endsection
