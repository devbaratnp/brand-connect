@extends('layouts.app')

@section('title', 'Inbox')

@section('content')
<div class="bc-page-header bc-flex" style="justify-content:space-between;align-items:center;">
    <h1 class="bc-page-title">Inbox</h1>
    <a href="{{ route('messages.create') }}" class="bc-btn bc-btn-primary">Compose</a>
</div>

@if($messages->isEmpty())
    <div class="bc-empty">
        <div class="bc-empty-icon">
            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <p class="bc-empty-text">No messages yet</p>
        <p class="bc-empty-sub">Messages from brands and creators will appear here.</p>
    </div>
@else
    <div class="bc-card">
        <div class="bc-list">
            @foreach($messages as $message)
                <a href="{{ route('messages.show', $message) }}" style="text-decoration:none;color:inherit;">
                    <div class="bc-list-item bc-flex" style="gap:1rem;align-items:center;padding:.75rem 1rem;{{ !$message->is_read ? 'background:var(--bc-bg-alt);border-left:3px solid var(--bc-primary);' : '' }}">
                        <div style="width:44px;height:44px;border-radius:50%;background:var(--bc-bg-alt);display:flex;align-items:center;justify-content:center;font-weight:600;color:var(--bc-text-muted);flex-shrink:0;">
                            {{ substr($message->sender->name ?? 'U', 0, 1) }}
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div class="bc-flex" style="justify-content:space-between;align-items:center;">
                                <span class="bc-list-item-title" style="{{ !$message->is_read ? 'font-weight:700;' : '' }}">
                                    {{ $message->sender->name ?? 'Unknown' }}
                                </span>
                                <span style="font-size:.75rem;color:var(--bc-text-muted);flex-shrink:0;margin-left:1rem;">
                                    {{ $message->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="bc-list-item-sub" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;{{ !$message->is_read ? 'color:var(--bc-text);font-weight:500;' : '' }}">
                                {{ Str::limit($message->message, 80) }}
                            </p>
                        </div>
                        @if(!$message->is_read)
                            <div style="width:10px;height:10px;border-radius:50%;background:var(--bc-primary);flex-shrink:0;"></div>
                        @endif
                    </div>
                </a>
                @if(!$loop->last)
                    <div class="bc-divider" style="margin:0;"></div>
                @endif
            @endforeach
        </div>
    </div>
@endif
@endsection
