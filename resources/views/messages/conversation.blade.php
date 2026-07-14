@extends('layouts.app')

@section('title', 'Conversation')

@section('content')
<div class="bc-page-header bc-flex" style="justify-content:space-between;align-items:center;">
    <div class="bc-flex" style="align-items:center;gap:1rem;">
        <a href="{{ route('messages.inbox') }}" class="bc-btn bc-btn-ghost bc-btn-sm">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div class="bc-flex" style="align-items:center;gap:.75rem;">
            <div style="width:40px;height:40px;border-radius:50%;background:var(--bc-bg-alt);display:flex;align-items:center;justify-content:center;font-weight:600;color:var(--bc-text-muted);">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h1 class="bc-page-title" style="margin:0;font-size:1.25rem;">{{ $user->name }}</h1>
            </div>
        </div>
    </div>
</div>

<div class="bc-card">
    <div class="bc-chat" style="display:flex;flex-direction:column;gap:.75rem;max-height:500px;overflow-y:auto;padding:1rem;">
        @forelse($messages as $msg)
            @php
                $isSent = $msg->sender_id === auth()->id();
            @endphp
            <div class="bc-chat-msg {{ $isSent ? 'bc-chat-sent' : 'bc-chat-received' }}" style="display:flex;flex-direction:column;{{ $isSent ? 'align-items:flex-end;' : 'align-items:flex-start;' }}max-width:75%;{{ $isSent ? 'align-self:flex-end;' : 'align-self:flex-start;' }}">
                @if(!$isSent)
                    <span class="bc-chat-sender" style="font-size:.75rem;font-weight:600;color:var(--bc-text-muted);margin-bottom:.25rem;">{{ $msg->sender->name ?? 'Unknown' }}</span>
                @endif
                <div style="background:{{ $isSent ? 'var(--bc-primary)' : 'var(--bc-bg-alt)' }};color:{{ $isSent ? 'var(--bc-primary-text, #fff)' : 'var(--bc-text)' }};padding:.75rem 1rem;border-radius:{{ $isSent ? '1rem 1rem .25rem 1rem' : '1rem 1rem 1rem .25rem' }};line-height:1.5;word-break:break-word;">
                    {!! nl2br(e($msg->message)) !!}
                </div>
                <span class="bc-chat-time" style="font-size:.7rem;color:var(--bc-text-muted);margin-top:.25rem;">{{ $msg->created_at->format('g:i A') }}</span>
            </div>
        @empty
            <div class="bc-empty">
                <p class="bc-empty-text">No messages yet</p>
                <p class="bc-empty-sub">Start the conversation below.</p>
            </div>
        @endforelse
    </div>

    <div class="bc-divider"></div>

    <form action="{{ route('messages.store') }}" method="POST" style="padding:1rem;">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $user->id }}">
        <div class="bc-flex" style="gap:.75rem;align-items:flex-end;">
            <div style="flex:1;">
                <textarea name="message" class="bc-input" rows="2" placeholder="Type a message..." required style="resize:none;">{{ old('message') }}</textarea>
                @error('message')
                    <p class="bc-error">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="bc-btn bc-btn-primary" style="height:fit-content;padding:.6rem 1.5rem;">
                Send
            </button>
        </div>
    </form>
</div>
@endsection
