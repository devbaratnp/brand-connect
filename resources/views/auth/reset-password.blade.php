@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="bc-flex" style="justify-content: center; align-items: center; min-height: 70vh;">
    <div class="bc-card" style="width: 100%; max-width: 440px;">
        <div class="bc-card-header">
            <h2 class="bc-card-title">Set New Password</h2>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="bc-form-group">
                <label class="bc-label" for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="bc-input @error('email') bc-input-error @enderror"
                    value="{{ $email ?? old('email') }}"
                    required
                    autofocus
                >
                @error('email')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="bc-form-group">
                <label class="bc-label" for="password">New Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="bc-input @error('password') bc-input-error @enderror"
                    required
                >
                @error('password')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="bc-form-group">
                <label class="bc-label" for="password_confirmation">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="bc-input"
                    required
                >
            </div>

            <button type="submit" class="bc-btn bc-btn-primary" style="width: 100%;">
                Reset Password
            </button>
        </form>
    </div>
</div>
@endsection
