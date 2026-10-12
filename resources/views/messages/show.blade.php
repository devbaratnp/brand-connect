@extends('layouts.app')

@section('title', 'Message')

@section('content')
<div class="bc-page-header bc-flex" style="justify-content:space-between;align-items:center;">
    <h1 class="bc-page-title">Message</h1>
    <a href="{{ route('messages.conversation', $message->sender_id === auth()->id() ? $message->receiver_id : $message->sender_id) }}" class="bc-btn bc-btn-primary">Reply</a>
</div>

<div class="bc-card" style="max-width:720px;">
    <div class="bc-card-header bc-flex" style="justify-content:space-between;align-items:center;">
        <div class="bc-flex" style="align-items:center;gap:1rem;">
            <div style="width:48px;height:48px;border-radius:50%;background:var(--soft);display:flex;align-items:center;justify-content:center;font-weight:600;font-size:1.25rem;color:var(--muted);">
                {{ substr($message->sender->name ?? 'U', 0, 1) }}
            </div>
            <div>
                <p class="bc-card-title" style="margin:0;">{{ $message->sender->name ?? 'Unknown' }}</p>
                <p class="bc-list-item-sub">Sender</p>
            </div>
        </div>
        <span style="font-size:.875rem;color:var(--muted);">{{ $message->created_at->format('M d, Y \a\t g:i A') }}</span>
    </div>
    <div class="bc-divider"></div>

    <div class="bc-list">
        <div class="bc-list-item" style="padding:.5rem 0;">
            <span class="bc-list-item-sub">To</span>
            <span class="bc-list-item-title">{{ $message->receiver->name ?? 'Unknown' }}</span>
        </div>
        @if($message->campaign)
            <div class="bc-list-item" style="padding:.5rem 0;">
                <span class="bc-list-item-sub">Campaign</span>
                <a href="{{ route('campaigns.show', $message->campaign) }}" style="color:var(--purple);text-decoration:none;font-weight:600;">
                    {{ $message->campaign->title }}
                </a>
            </div>
        @endif
    </div>

    <div class="bc-divider"></div>

    <div style="padding:.5rem 0;line-height:1.7;color:var(--ink);">
        {!! nl2br(e($message->message)) !!}
    </div>

    <div class="bc-divider"></div>

    <div class="bc-flex" style="justify-content:flex-end;gap:.75rem;">
        <a href="{{ route('messages.inbox') }}" class="bc-btn bc-btn-ghost bc-btn-sm">Back to Inbox</a>
        <a href="{{ route('messages.conversation', $message->sender_id === auth()->id() ? $message->receiver_id : $message->sender_id) }}" class="bc-btn bc-btn-primary bc-btn-sm">Reply</a>
    </div>
</div>
@endsection
