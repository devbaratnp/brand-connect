@extends('layouts.app')

@section('title', 'Reviews')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Reviews for {{ $user->name }}</h1>
</div>

@if($reviews->isEmpty())
    <div class="bc-empty">
        <div class="bc-empty-icon">
            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
        </div>
        <p class="bc-empty-text">No reviews yet</p>
        <p class="bc-empty-sub">This user hasn't received any reviews.</p>
    </div>
@else
    <div class="bc-flex" style="align-items:center;gap:1.5rem;margin-bottom:2rem;">
        <div style="width:64px;height:64px;border-radius:50%;background:var(--soft);display:flex;align-items:center;justify-content:center;font-weight:600;font-size:1.75rem;color:var(--muted);">
            {{ substr($user->name, 0, 1) }}
        </div>
        <div>
            <p style="font-weight:600;font-size:1.125rem;">{{ $user->name }}</p>
            <p style="color:var(--muted);font-size:.875rem;">
                {{ number_format($averageRating ?? 0, 1) }} average rating &middot; {{ $reviews->count() }} {{ Str::plural('review', $reviews->count()) }}
            </p>
        </div>
    </div>

    <div class="bc-grid-2" style="gap:1.5rem;">
        @foreach($reviews as $review)
            <div class="bc-card">
                <div class="bc-card-header bc-flex" style="justify-content:space-between;align-items:start;">
                    <div>
                        <div class="bc-flex" style="align-items:center;gap:.5rem;">
                            <div style="width:36px;height:36px;border-radius:50%;background:var(--soft);display:flex;align-items:center;justify-content:center;font-weight:600;font-size:.875rem;color:var(--muted);">
                                {{ substr($review->reviewer->name ?? 'U', 0, 1) }}
                            </div>
                            <span class="bc-card-title" style="font-size:.95rem;">{{ $review->reviewer->name ?? 'Anonymous' }}</span>
                        </div>
                    </div>
                    <span style="font-size:.875rem;color:var(--muted);">
                        {{ $review->created_at->format('M d, Y') }}
                    </span>
                </div>
                <div class="bc-divider"></div>
                <div class="bc-flex" style="gap:.25rem;margin-bottom:.5rem;">
                    @for($i = 1; $i <= 5; $i++)
                        <span style="font-size:1.25rem;color:{{ $i <= $review->rating ? '#f59e0b' : 'var(--muted)' }};">&#9733;</span>
                    @endfor
                    <span style="font-size:.875rem;color:var(--muted);margin-left:.5rem;">{{ $review->rating }}/5</span>
                </div>
                <p style="line-height:1.6;color:var(--ink);">{{ $review->review }}</p>
                @if($review->campaign)
                    <div class="bc-divider"></div>
                    <a href="{{ route('campaigns.show', $review->campaign) }}" style="font-size:.875rem;color:var(--purple);text-decoration:none;">
                        Campaign: {{ $review->campaign->title }}
                    </a>
                @endif
            </div>
        @endforeach
    </div>
@endif
@endsection
