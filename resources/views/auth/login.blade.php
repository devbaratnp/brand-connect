@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="bc-flex" style="justify-content: center; align-items: center; min-height: 70vh;">
    <div class="bc-card" style="width: 100%; max-width: 440px;">
        <div class="bc-card-header">
            <h2 class="bc-card-title">Sign In</h2>
        </div>

        @if (session('status'))
            <div class="bc-alert bc-alert-success" style="margin-bottom: 1rem;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
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

            <div class="bc-form-group">
                <label class="bc-label" for="password">Password</label>
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

            <div class="bc-form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} style="width: auto;">
                <label class="bc-label" for="remember" style="margin-bottom: 0;">Remember me</label>
            </div>

            <button type="submit" class="bc-btn bc-btn-primary" style="width: 100%;">
                Login
            </button>

            <p style="text-align: center; margin-top: 1rem; color: var(--text-muted, #888); font-size: 0.9rem;">
                <a href="{{ route('password.request') }}" class="bc-btn bc-btn-ghost bc-btn-sm" style="padding: 0; border: none; text-decoration: underline;">
                    Forgot your password?
                </a>
            </p>

            <p style="text-align: center; margin-top: 0.5rem; color: var(--text-muted, #888); font-size: 0.9rem;">
                Don't have an account?
                <a href="{{ route('register') }}" class="bc-btn bc-btn-ghost bc-btn-sm" style="padding: 0; border: none; text-decoration: underline;">
                    Register
                </a>
            </p>
        </form>
    </div>
</div>
@endsection
