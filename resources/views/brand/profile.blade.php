@extends('layouts.app')

@section('title', 'Company Profile')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Company Profile</h1>
</div>

<div class="bc-card" style="max-width: 720px;">
    <div class="bc-card-header">
        <h2 class="bc-card-title">Edit Company Information</h2>
    </div>

    <form method="POST" action="{{ route('brand.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="bc-form-group">
            <label class="bc-label" for="company_name">Company Name</label>
            <input
                type="text"
                id="company_name"
                name="company_name"
                class="bc-input @error('company_name') bc-input-error @enderror"
                value="{{ old('company_name', $profile->company_name ?? '') }}"
                required
            />
            @error('company_name')
                <span class="bc-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="bc-form-group">
            <label class="bc-label" for="industry">Industry</label>
            <input
                type="text"
                id="industry"
                name="industry"
                class="bc-input @error('industry') bc-input-error @enderror"
                value="{{ old('industry', $profile->industry ?? '') }}"
            />
            @error('industry')
                <span class="bc-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="bc-form-group">
            <label class="bc-label" for="description">Description</label>
            <textarea
                id="description"
                name="description"
                class="bc-input @error('description') bc-input-error @enderror"
                rows="5"
            >{{ old('description', $profile->description ?? '') }}</textarea>
            @error('description')
                <span class="bc-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="bc-form-group">
            <label class="bc-label" for="website">Website</label>
            <input
                type="url"
                id="website"
                name="website"
                class="bc-input @error('website') bc-input-error @enderror"
                value="{{ old('website', $profile->website ?? '') }}"
                placeholder="https://"
            />
            @error('website')
                <span class="bc-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="bc-form-group">
            <label class="bc-label" for="location">Location</label>
            <input
                type="text"
                id="location"
                name="location"
                class="bc-input @error('location') bc-input-error @enderror"
                value="{{ old('location', $profile->location ?? '') }}"
            />
            @error('location')
                <span class="bc-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="bc-flex" style="gap:.75rem;margin-top: 1.5rem;">
            <button type="submit" class="bc-btn bc-btn-primary">Save Profile</button>
            <a href="{{ route('dashboard') }}" class="bc-btn bc-btn-ghost">Back to Dashboard</a>
        </div>
    </form>
</div>
@endsection
