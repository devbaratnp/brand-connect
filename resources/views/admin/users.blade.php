@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Manage Users</h1>
</div>

<div class="bc-card">
    <div class="bc-card-header">
        <h2 class="bc-card-title">All Users</h2>
    </div>
    <div class="bc-table-wrap">
        <table class="bc-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="bc-badge bc-badge-admin">Admin</span>
                            @elseif($user->role === 'brand')
                                <span class="bc-badge bc-badge-brand">Brand</span>
                            @else
                                <span class="bc-badge bc-badge-creator">Creator</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active ?? true)
                                <span class="bc-badge bc-badge-active">Active</span>
                            @else
                                <span class="bc-badge bc-badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="bc-flex" style="gap: 0.5rem; align-items: center;">
                                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bc-btn bc-btn-warning bc-btn-xs">
                                        {{ ($user->is_active ?? true) ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.users.delete', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    <button type="submit" class="bc-btn bc-btn-danger bc-btn-xs">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="bc-empty">
                                <div class="bc-empty-icon">👤</div>
                                <div class="bc-empty-text">No users found</div>
                                <div class="bc-empty-sub">There are no registered users yet.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div style="padding: 1rem; text-align: center;">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
