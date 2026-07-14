@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="bc-flex" style="justify-content: center; align-items: center; min-height: 70vh;">
    <div class="bc-card" style="width: 100%; max-width: 520px;">
        <div class="bc-card-header">
            <h2 class="bc-card-title">Create Account</h2>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="bc-form-group">
                <label class="bc-label" for="name">Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="bc-input @error('name') bc-input-error @enderror"
                    value="{{ old('name') }}"
                    required
                    autofocus
                >
                @error('name')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="bc-form-group">
                <label class="bc-label" for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="bc-input @error('email') bc-input-error @enderror"
                    value="{{ old('email') }}"
                    required
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

            <div class="bc-form-group">
                <label class="bc-label" style="margin-bottom: 0.75rem;">I am a...</label>
                <div class="bc-role-cards">
                    <label class="bc-role-card {{ old('role') === 'creator' ? 'selected' : '' }}">
                        <input type="radio" name="role" value="creator" {{ old('role') === 'creator' ? 'checked' : '' }} style="display: none;">
                        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🎬</div>
                        <strong>Creator</strong>
                        <span style="font-size: 0.8rem; color: var(--text-muted, #888);">I create content</span>
                    </label>
                    <label class="bc-role-card {{ old('role') === 'brand' ? 'selected' : '' }}">
                        <input type="radio" name="role" value="brand" {{ old('role') === 'brand' ? 'checked' : '' }} style="display: none;">
                        <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🏢</div>
                        <strong>Brand</strong>
                        <span style="font-size: 0.8rem; color: var(--text-muted, #888);">I hire creators</span>
                    </label>
                </div>
                @error('role')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="bc-btn bc-btn-primary" style="width: 100%; margin-top: 0.5rem;">
                Register
            </button>

            <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted, #888); font-size: 0.9rem;">
                Already have an account?
                <a href="{{ route('login') }}" class="bc-btn bc-btn-ghost bc-btn-sm" style="padding: 0; border: none; text-decoration: underline;">
                    Sign in
                </a>
            </p>
        </form>
    </div>
</div>
@endsection
