@extends('layouts.app')

@section('title', 'Manage Applications')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Applications for {{ $campaign->title }}</h1>
    <a href="{{ route('brand.campaigns.show', $campaign) }}" class="bc-btn bc-btn-ghost" style="margin-top: 0.5rem;">Back to Campaign</a>
</div>

@if($applications->isEmpty())
    <div class="bc-card">
        <div class="bc-empty">
            <div class="bc-empty-icon">&#128101;</div>
            <p class="bc-empty-text">No applications yet</p>
            <p class="bc-empty-sub">Creators will apply to your campaign. Check back soon.</p>
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
                        <p style="margin-top: 0.75rem; color: var(--bc-text, #1f2937); line-height: 1.6;">{{ $application->message }}</p>
                    @endif
                </div>

                @if($application->status === 'pending')
                    <div class="bc-flex" style="gap: 0.5rem; margin-top: 0.5rem;">
                        <form method="POST" action="{{ route('brand.applications.accept', $application) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bc-btn bc-btn-sm bc-btn-success">Accept</button>
                        </form>
                        <form method="POST" action="{{ route('brand.applications.reject', $application) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bc-btn bc-btn-sm bc-btn-danger">Reject</button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif
@endsection
