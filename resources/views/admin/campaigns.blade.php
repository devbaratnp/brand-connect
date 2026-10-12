@extends('layouts.app')

@section('title', 'Manage Campaigns')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Manage Campaigns</h1>
</div>

<div class="bc-card">
    <div class="bc-card-header">
        <h2 class="bc-card-title">All Campaigns</h2>
    </div>
    <div class="bc-table-wrap">
        <table class="bc-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Brand</th>
                    <th>Budget</th>
                    <th>Applications</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($campaigns as $campaign)
                    <tr>
                        <td>{{ $campaign->id }}</td>
                        <td><strong>{{ $campaign->title }}</strong></td>
                        <td>{{ $campaign->brand->name ?? '—' }}</td>
                        <td>Rs. {{ number_format($campaign->budget) }}</td>
                        <td>{{ $campaign->applications_count ?? $campaign->applications->count() ?? 0 }}</td>
                        <td>
                            @if($campaign->status === 'open')
                                <span class="bc-badge bc-badge-open">Open</span>
                            @elseif($campaign->status === 'in_progress')
                                <span class="bc-badge bc-badge-progress">In Progress</span>
                            @else
                                <span class="bc-badge bc-badge-closed">Closed</span>
                            @endif
                        </td>
                        <td>{{ $campaign->created_at->format('M d, Y') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.campaigns.delete', $campaign) }}" onsubmit="return confirm('Are you sure you want to delete this campaign?');">
                                @csrf
                                <button type="submit" class="bc-btn bc-btn-danger bc-btn-xs">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="bc-empty">
                                <div class="bc-empty-icon">📋</div>
                                <div class="bc-empty-text">No campaigns found</div>
                                <div class="bc-empty-sub">No campaigns have been created yet.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($campaigns->hasPages())
        <div style="padding: 1rem; text-align: center;">
            {{ $campaigns->links() }}
        </div>
    @endif
</div>
@endsection
