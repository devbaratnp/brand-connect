@extends('layouts.app')

@section('title', 'My Campaigns')

@section('content')
<div class="bc-page-header bc-flex" style="justify-content: space-between; align-items: center;">
    <h1 class="bc-page-title">My Campaigns</h1>
    <a href="{{ route('campaigns.create') }}" class="bc-btn bc-btn-primary">New Campaign</a>
</div>

@if($campaigns->isEmpty())
    <div class="bc-card">
        <div class="bc-empty">
            <div class="bc-empty-icon">&#128640;</div>
            <p class="bc-empty-text">No campaigns yet</p>
            <p class="bc-empty-sub">Create your first campaign to start finding creators for your brand.</p>
            <a href="{{ route('campaigns.create') }}" class="bc-btn bc-btn-primary" style="margin-top: 1rem;">Create Campaign</a>
        </div>
    </div>
@else
    <div class="bc-table-wrap">
        <table class="bc-table">
            <thead>
                <tr>
                    <th>Campaign</th>
                    <th>Status</th>
                    <th>Applications</th>
                    <th>Budget</th>
                    <th>Deadline</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($campaigns as $campaign)
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $campaign->title }}</div>
                            @if($campaign->description)
                                <div style="color: var(--muted); font-size: 0.85rem; margin-top: 0.25rem;">{{ Str::limit($campaign->description, 60) }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="bc-badge bc-badge-{{ $campaign->status }}">{{ ucfirst($campaign->status) }}</span>
                        </td>
                        <td>{{ $campaign->applications_count ?? $campaign->applications->count() }}</td>
                        <td>{{ $campaign->budget !== null ? 'Rs. ' . number_format($campaign->budget, 2) : 'Not specified' }}</td>
                        <td>{{ $campaign->deadline ? \Carbon\Carbon::parse($campaign->deadline)->format('M d, Y') : '—' }}</td>
                        <td style="text-align: right;">
                            <a href="{{ route('campaigns.show', $campaign) }}" class="bc-btn bc-btn-sm bc-btn-ghost">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
