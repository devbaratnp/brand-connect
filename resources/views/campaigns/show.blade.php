@extends('layouts.app')

@section('title', $campaign->title)

@section('content')
<div class="bc-page-header bc-flex" style="justify-content:space-between;align-items:start;">
    <div>
        <h1 class="bc-page-title">{{ $campaign->title }}</h1>
        <p style="color:var(--muted);margin-top:.25rem;">
            by {{ $campaign->brand->name ?? 'Brand' }}
        </p>
    </div>
    @if($campaign->status === 'open')
        <span class="bc-badge bc-badge-open">Open</span>
    @elseif($campaign->status === 'in_progress')
        <span class="bc-badge bc-badge-progress">In Progress</span>
    @elseif($campaign->status === 'closed')
        <span class="bc-badge bc-badge-closed">Closed</span>
    @elseif($campaign->status === 'cancelled')
        <span class="bc-badge bc-badge-cancelled">Cancelled</span>
    @else
        <span class="bc-badge bc-badge-pending">{{ ucfirst($campaign->status) }}</span>
    @endif
</div>

<div class="bc-grid-2" style="gap:1.5rem;align-items:start;">
    <div class="bc-card">
        <div class="bc-card-header">
            <h2 class="bc-card-title">Campaign Details</h2>
        </div>
        <div class="bc-divider"></div>
        <div style="line-height:1.7;color:var(--ink);">
            {!! nl2br(e($campaign->description)) !!}
        </div>

        <div class="bc-divider"></div>
        <div class="bc-list">
            <div class="bc-list-item" style="padding:.5rem 0;">
                <span class="bc-list-item-sub">Budget</span>
                <span class="bc-list-item-title" style="font-size:1.25rem;">{{ $campaign->budget !== null ? 'Rs. ' . number_format($campaign->budget, 2) : 'Not specified' }}</span>
            </div>
            <div class="bc-list-item" style="padding:.5rem 0;">
                <span class="bc-list-item-sub">Deadline</span>
                <span class="bc-list-item-title">{{ $campaign->deadline ? \Carbon\Carbon::parse($campaign->deadline)->format('M d, Y') : 'Flexible' }}</span>
            </div>
            <div class="bc-list-item" style="padding:.5rem 0;">
                <span class="bc-list-item-sub">Category</span>
                <span class="bc-list-item-title">{{ $campaign->category->name ?? 'N/A' }}</span>
            </div>
            @if($campaign->requirements)
                <div class="bc-list-item" style="padding:.5rem 0;">
                    <span class="bc-list-item-sub">Requirements</span>
                    <span class="bc-list-item-title">{{ $campaign->requirements }}</span>
                </div>
            @endif
        </div>
    </div>

    <div>
        @if(auth()->check() && auth()->user()->role === 'creator')
            <div class="bc-card">
                <div class="bc-card-header">
                    <h2 class="bc-card-title">Apply to Campaign</h2>
                </div>
                <div class="bc-divider"></div>

                @if($hasApplied)
                    <div class="bc-badge bc-badge-progress" style="font-size:.875rem;">You have already applied</div>
                @else
                    <form action="{{ route('campaigns.apply', $campaign) }}" method="POST">
                        @csrf
                        <div class="bc-form-group">
                            <label class="bc-label" for="message">Your Message</label>
                            <textarea name="message" id="message" class="bc-input" rows="4" placeholder="Why are you a good fit for this campaign?" required>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="bc-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bc-btn bc-btn-primary" style="width:100%;">Submit Application</button>
                    </form>
                @endif
            </div>
        @endif

        @if(auth()->check() && auth()->user()->role === 'brand')
            <div class="bc-card">
                <div class="bc-card-header">
                    <h2 class="bc-card-title">Manage Campaign</h2>
                </div>
                <div class="bc-divider"></div>
                <div class="bc-list">
                    <div class="bc-list-item" style="padding:.5rem 0;">
                        <span class="bc-list-item-sub">Applications</span>
                        <span class="bc-list-item-title">{{ $campaign->applications->count() }}</span>
                    </div>
                </div>
                <div class="bc-divider"></div>
                <div class="bc-flex" style="gap:.75rem;">
                    <a href="{{ route('campaigns.edit', $campaign) }}" class="bc-btn bc-btn-dark bc-btn-sm">Edit Campaign</a>
                    <a href="{{ route('brand.applications', $campaign) }}" class="bc-btn bc-btn-ghost bc-btn-sm">View Applications</a>
                    <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Delete this campaign? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bc-btn bc-btn-sm bc-btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        @endif

        <div class="bc-card" style="margin-top:1.5rem;">
            <div class="bc-card-header">
                <h2 class="bc-card-title">Brand</h2>
            </div>
            <div class="bc-divider"></div>
            <div class="bc-flex" style="align-items:center;gap:1rem;">
                <div style="width:48px;height:48px;border-radius:50%;background:var(--soft);display:flex;align-items:center;justify-content:center;font-weight:600;font-size:1.25rem;color:var(--muted);">
                    {{ substr($campaign->brand->name ?? 'B', 0, 1) }}
                </div>
                <div>
                    <p class="bc-list-item-title">{{ $campaign->brand->name ?? 'Brand' }}</p>
                    <a href="{{ route('reviews.show', $campaign->brand_id) }}" class="bc-list-item-sub" style="color:var(--purple);text-decoration:none;">View Reviews</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
