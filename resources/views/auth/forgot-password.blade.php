@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="bc-flex" style="justify-content: center; align-items: center; min-height: 70vh;">
    <div class="bc-card" style="width: 100%; max-width: 440px;">
        <div class="bc-card-header">
            <h2 class="bc-card-title">Reset Password</h2>
        </div>

        @if (session('status'))
            <div class="bc-alert bc-alert-success" style="margin-bottom: 1rem;">
                {{ session('status') }}
            </div>
        @endif

        <p style="color: var(--text-muted, #888); font-size: 0.9rem; margin-bottom: 1.5rem;">
            Enter your email address and we'll send you a link to reset your password.
        </p>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="bc-form-group">
                <label class="bc-label" for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="bc-input @error('email') bc-input-error @enderror"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
                @error('email')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="bc-btn bc-btn-primary" style="width: 100%;">
                Send Reset Link
            </button>

            <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted, #888); font-size: 0.9rem;">
                Remember your password?
                <a href="{{ route('login') }}" class="bc-btn bc-btn-ghost bc-btn-sm" style="padding: 0; border: none; text-decoration: underline;">
                    Login
                </a>
            </p>
        </form>
    </div>
</div>
@endsection
