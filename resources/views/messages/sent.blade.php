@extends('layouts.app')

@section('title', 'Sent Messages')

@section('content')
<div class="bc-page-header bc-flex" style="justify-content:space-between;align-items:center;">
    <h1 class="bc-page-title">Sent Messages</h1>
    <a href="{{ route('messages.create') }}" class="bc-btn bc-btn-primary">Compose</a>
</div>

@if($messages->isEmpty())
    <div class="bc-empty">
        <div class="bc-empty-icon">
            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
        </div>
        <p class="bc-empty-text">No sent messages</p>
        <p class="bc-empty-sub">Messages you send will appear here.</p>
    </div>
@else
    <div class="bc-card">
        <div class="bc-list">
            @foreach($messages as $message)
                <a href="{{ route('messages.show', $message) }}" style="text-decoration:none;color:inherit;">
                    <div class="bc-list-item bc-flex" style="gap:1rem;align-items:center;padding:.75rem 1rem;">
                        <div style="width:44px;height:44px;border-radius:50%;background:var(--bc-bg-alt);display:flex;align-items:center;justify-content:center;font-weight:600;color:var(--bc-text-muted);flex-shrink:0;">
                            {{ substr($message->receiver->name ?? 'U', 0, 1) }}
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div class="bc-flex" style="justify-content:space-between;align-items:center;">
                                <span class="bc-list-item-title">To: {{ $message->receiver->name ?? 'Unknown' }}</span>
                                <span style="font-size:.75rem;color:var(--bc-text-muted);flex-shrink:0;margin-left:1rem;">
                                    {{ $message->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="bc-list-item-sub" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ Str::limit($message->message, 80) }}
                            </p>
                        </div>
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
