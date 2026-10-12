@extends('layouts.app')

@section('title', 'Deliverables')

@section('content')
<div class="bc-page-header">
    <div>
        <h1 class="bc-page-title">Deliverables</h1>
        <p class="bc-page-subtitle">{{ Auth::user()->isCreator() ? 'Your accepted campaigns and ongoing work.' : 'Accepted creators and their deliverables.' }}</p>
    </div>
</div>

@if($deliverables->isEmpty())
    <div class="bc-card">
        <div class="bc-empty">
            <div class="bc-empty-icon">
                <i class="bi bi-box" style="font-size: 2rem;"></i>
            </div>
            <p class="bc-empty-text">No deliverables yet</p>
            <p class="bc-empty-sub">{{ Auth::user()->isCreator() ? 'Once your applications are accepted, your campaigns will appear here.' : 'Accepted creators and their work will appear here once applications are approved.' }}</p>
            @if(Auth::user()->isCreator())
                <a href="{{ route('campaigns.browse') }}" class="bc-btn bc-btn-primary" style="margin-top: 1rem;">
                    <i class="bi bi-search"></i> Browse Opportunities
                </a>
            @else
                <a href="{{ route('brand.campaigns') }}" class="bc-btn bc-btn-primary" style="margin-top: 1rem;">View Campaigns</a>
            @endif
        </div>
    </div>
@else
    <div class="bc-grid-2">
        @foreach($deliverables as $deliverable)
            <div class="bc-card">
                <div class="bc-card-header">
                    <h2 class="bc-card-title">{{ $deliverable->campaign->title }}</h2>
                    <span class="bc-badge bc-badge-progress">In Progress</span>
                </div>
                @if(Auth::user()->isCreator())
                    <p style="font-size:14px;color:var(--muted);margin-bottom:12px;">
                        <i class="bi bi-building"></i> {{ $deliverable->campaign->brand->name ?? 'Brand' }}
                    </p>
                @else
                    <p style="font-size:14px;color:var(--muted);margin-bottom:12px;">
                        <i class="bi bi-person"></i> {{ $deliverable->creator->name ?? 'Creator' }}
                    </p>
                @endif
                <div style="font-size:13px;color:var(--muted);margin-bottom:16px;">
                    <div>Budget: {{ $deliverable->campaign->budget !== null ? 'Rs. ' . number_format($deliverable->campaign->budget, 0) : 'Not specified' }}</div>
                    @if($deliverable->campaign->deadline)
                        <div>Deadline: {{ \Carbon\Carbon::parse($deliverable->campaign->deadline)->format('M d, Y') }}</div>
                    @endif
                </div>
                <div class="bc-flex" style="gap:.5rem;">
                    <a href="{{ route('campaigns.show', $deliverable->campaign) }}" class="bc-btn bc-btn-sm bc-btn-primary">
                        <i class="bi bi-eye"></i> View Details
                    </a>
                    @if(Auth::user()->isCreator())
                        <a href="{{ route('reviews.create', $deliverable->campaign) }}?for={{ $deliverable->campaign->brand_id }}" class="bc-btn bc-btn-sm bc-btn-ghost">Leave Review</a>
                    @else
                        <a href="{{ route('reviews.create', $deliverable->campaign) }}?for={{ $deliverable->creator_id }}" class="bc-btn bc-btn-sm bc-btn-ghost">Leave Review</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
