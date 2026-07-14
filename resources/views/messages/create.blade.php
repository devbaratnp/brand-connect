@extends('layouts.app')

@section('title', 'Compose Message')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Compose Message</h1>
</div>

<div class="bc-card" style="max-width:640px;">
    <div class="bc-card-header">
        <h2 class="bc-card-title">New Message</h2>
    </div>
    <div class="bc-divider"></div>

    <form action="{{ route('messages.store') }}" method="POST">
        @csrf

        <div class="bc-form-group">
            <label class="bc-label" for="receiver_id">To</label>
            <select name="receiver_id" id="receiver_id" class="bc-input" required>
                <option value="">Select recipient</option>
                @foreach($users as $user)
                    @if($user->id !== auth()->id())
                        <option value="{{ $user->id }}" {{ old('receiver_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endif
                @endforeach
            </select>
            @error('receiver_id')
                <p class="bc-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="bc-form-group">
            <label class="bc-label" for="campaign_id">Campaign (optional)</label>
            <select name="campaign_id" id="campaign_id" class="bc-input">
                <option value="">No campaign</option>
                @foreach($campaigns as $campaign)
                    <option value="{{ $campaign->id }}" {{ old('campaign_id') == $campaign->id ? 'selected' : '' }}>
                        {{ $campaign->title }}
                    </option>
                @endforeach
            </select>
            @error('campaign_id')
                <p class="bc-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="bc-form-group">
            <label class="bc-label" for="message">Message</label>
            <textarea name="message" id="message" class="bc-input" rows="6" placeholder="Write your message..." required>{{ old('message') }}</textarea>
            @error('message')
                <p class="bc-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="bc-flex" style="justify-content:flex-end;gap:.75rem;margin-top:1rem;">
            <a href="{{ route('messages.inbox') }}" class="bc-btn bc-btn-ghost">Cancel</a>
            <button type="submit" class="bc-btn bc-btn-primary">Send Message</button>
        </div>
    </form>
</div>
@endsection
