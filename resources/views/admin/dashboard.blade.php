@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Admin Dashboard</h1>
</div>

<div class="bc-grid-3" style="margin-bottom: 2rem;">
    <div class="bc-stat">
        <div class="bc-stat-icon bc-stat-icon-lime">
            <i class="bi bi-people"></i>
        </div>
        <div>
            <span class="bc-stat-value">{{ number_format($stats['total_users']) }}</span>
            <span class="bc-stat-label">Total Users</span>
            <span class="bc-stat-sub">{{ $stats['total_creators'] }} creators &middot; {{ $stats['total_brands'] }} brands</span>
        </div>
    </div>
    <div class="bc-stat">
        <div class="bc-stat-icon bc-stat-icon-purple">
            <i class="bi bi-megaphone"></i>
        </div>
        <div>
            <span class="bc-stat-value">{{ number_format($stats['total_campaigns']) }}</span>
            <span class="bc-stat-label">Total Campaigns</span>
            <span class="bc-stat-sub">All time</span>
        </div>
    </div>
    <div class="bc-stat">
        <div class="bc-stat-icon bc-stat-icon-ink">
            <i class="bi bi-file-earmark-text"></i>
        </div>
        <div>
            <span class="bc-stat-value">{{ number_format($stats['total_applications']) }}</span>
            <span class="bc-stat-label">Applications</span>
            <span class="bc-stat-sub">{{ $stats['pending_applications'] }} pending review</span>
        </div>
    </div>
</div>

<div class="bc-grid-2" style="gap: 2rem;">
    <div class="bc-card">
        <div class="bc-card-header">
            <h2 class="bc-card-title">Recent Users</h2>
            <a href="{{ route('admin.users') }}" class="bc-btn bc-btn-ghost bc-btn-sm">View All</a>
        </div>
        <div class="bc-table-wrap">
            <table class="bc-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="bc-badge bc-badge-admin">Admin</span>
                                @elseif($user->role === 'brand')
                                    <span class="bc-badge bc-badge-brand">Brand</span>
                                @else
                                    <span class="bc-badge bc-badge-creator">Creator</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted, #888); padding: 1.5rem;">No users yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bc-card">
        <div class="bc-card-header">
            <h2 class="bc-card-title">Recent Campaigns</h2>
            <a href="{{ route('admin.campaigns') }}" class="bc-btn bc-btn-ghost bc-btn-sm">View All</a>
        </div>
        <div class="bc-table-wrap">
            <table class="bc-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Budget</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_campaigns as $campaign)
                        <tr>
                            <td>{{ $campaign->id }}</td>
                            <td>{{ $campaign->title }}</td>
                            <td>Rs. {{ number_format($campaign->budget) }}</td>
                            <td>
                                @if($campaign->status === 'open')
                                    <span class="bc-badge bc-badge-open">Open</span>
                                @elseif($campaign->status === 'in_progress')
                                    <span class="bc-badge bc-badge-progress">In Progress</span>
                                @else
                                    <span class="bc-badge bc-badge-closed">Closed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted, #888); padding: 1.5rem;">No campaigns yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
