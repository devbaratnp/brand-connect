@extends('layouts.app')

@section('title', 'My Applications')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">My Applications</h1>
</div>

@if($applications->isEmpty())
    <div class="bc-card">
        <div class="bc-empty">
            <div class="bc-empty-icon">&#128640;</div>
            <p class="bc-empty-text">No applications yet</p>
            <p class="bc-empty-sub">Browse available campaigns and send your first application.</p>
            <a href="{{ route('campaigns.index') }}" class="bc-btn bc-btn-primary" style="margin-top: 1rem;">Browse Campaigns</a>
        </div>
    </div>
@else
    <div class="bc-table-wrap">
        <table class="bc-table">
            <thead>
                <tr>
                    <th>Campaign</th>
                    <th>Brand</th>
                    <th>Status</th>
                    <th>Applied</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>
                            <a href="{{ route('campaigns.show', $application->campaign) }}" style="font-weight: 600; color: inherit; text-decoration: none;">
                                {{ $application->campaign->title ?? 'Campaign' }}
                            </a>
                        </td>
                        <td>{{ $application->campaign->brand->company_name ?? $application->campaign->brand->name ?? 'Brand' }}</td>
                        <td>
                            <span class="bc-badge bc-badge-{{ $application->status }}">{{ ucfirst($application->status) }}</span>
                        </td>
                        <td>{{ $application->created_at->format('M d, Y') }}</td>
                        <td style="max-width: 260px;">
                            <span style="color: var(--bc-muted, #6b7280);">{{ Str::limit($application->message ?? '—', 60) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
