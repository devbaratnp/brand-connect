@extends('layouts.app')

@section('title', 'Creator Profile')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Creator Profile</h1>
</div>

<div class="bc-card" style="max-width: 720px;">
    <div class="bc-card-header">
        <h2 class="bc-card-title">Edit Your Profile</h2>
    </div>

    <form method="POST" action="{{ route('creator.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="bc-grid-2">
            <div class="bc-form-group">
                <label class="bc-label" for="niche">Niche</label>
                <input
                    type="text"
                    id="niche"
                    name="niche"
                    class="bc-input @error('niche') bc-input-error @enderror"
                    value="{{ old('niche', $profile->niche ?? '') }}"
                />
                @error('niche')
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
        </div>

        <div class="bc-grid-2">
            <div class="bc-form-group">
                <label class="bc-label" for="social_media_platform">Social Media Platform</label>
                <input
                    type="text"
                    id="social_media_platform"
                    name="social_media_platform"
                    class="bc-input @error('social_media_platform') bc-input-error @enderror"
                    value="{{ old('social_media_platform', $profile->social_media_platform ?? '') }}"
                    placeholder="e.g. Instagram, YouTube, TikTok"
                />
                @error('social_media_platform')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="bc-form-group">
                <label class="bc-label" for="social_media_link">Social Media Link</label>
                <input
                    type="url"
                    id="social_media_link"
                    name="social_media_link"
                    class="bc-input @error('social_media_link') bc-input-error @enderror"
                    value="{{ old('social_media_link', $profile->social_media_link ?? '') }}"
                    placeholder="https://"
                />
                @error('social_media_link')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="bc-grid-3">
            <div class="bc-form-group">
                <label class="bc-label" for="follower_count">Follower Count</label>
                <input
                    type="number"
                    id="follower_count"
                    name="follower_count"
                    class="bc-input @error('follower_count') bc-input-error @enderror"
                    value="{{ old('follower_count', $profile->follower_count ?? '') }}"
                    min="0"
                />
                @error('follower_count')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="bc-form-group">
                <label class="bc-label" for="engagement_rate">Engagement Rate (%)</label>
                <input
                    type="number"
                    id="engagement_rate"
                    name="engagement_rate"
                    class="bc-input @error('engagement_rate') bc-input-error @enderror"
                    value="{{ old('engagement_rate', $profile->engagement_rate ?? '') }}"
                    step="0.01"
                    min="0"
                    max="100"
                />
                @error('engagement_rate')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="bc-form-group">
                <label class="bc-label" for="price_per_post">Price Per Post (Rs.)</label>
                <input
                    type="number"
                    id="price_per_post"
                    name="price_per_post"
                    class="bc-input @error('price_per_post') bc-input-error @enderror"
                    value="{{ old('price_per_post', $profile->price_per_post ?? '') }}"
                    step="0.01"
                    min="0"
                />
                @error('price_per_post')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="bc-form-group">
            <label class="bc-label" for="portfolio">Portfolio</label>
            <textarea
                id="portfolio"
                name="portfolio"
                class="bc-input @error('portfolio') bc-input-error @enderror"
                rows="4"
                placeholder="Share links to your best work..."
            >{{ old('portfolio', $profile->portfolio ?? '') }}</textarea>
            @error('portfolio')
                <span class="bc-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="bc-form-group">
            <label class="bc-label" for="audience_details">Audience Details</label>
            <textarea
                id="audience_details"
                name="audience_details"
                class="bc-input @error('audience_details') bc-input-error @enderror"
                rows="3"
                placeholder="Describe your audience demographics..."
            >{{ old('audience_details', $profile->audience_details ?? '') }}</textarea>
            @error('audience_details')
                <span class="bc-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="bc-grid-2">
            <div class="bc-form-group">
                <label class="bc-label" for="availability">Availability</label>
                <select
                    id="availability"
                    name="availability"
                    class="bc-input @error('availability') bc-input-error @enderror"
                >
                    <option value="available" {{ old('availability', $profile->availability ?? '') === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="busy" {{ old('availability', $profile->availability ?? '') === 'busy' ? 'selected' : '' }}>Busy</option>
                    <option value="unavailable" {{ old('availability', $profile->availability ?? '') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                </select>
                @error('availability')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="bc-form-group">
                <label class="bc-label" for="category_id">Category</label>
                <select
                    id="category_id"
                    name="category_id"
                    class="bc-input @error('category_id') bc-input-error @enderror"
                >
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $profile->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="bc-flex" style="gap:.75rem;margin-top: 1.5rem;">
            <button type="submit" class="bc-btn bc-btn-primary">Save Profile</button>
            <a href="{{ route('dashboard') }}" class="bc-btn bc-btn-ghost">Back to Dashboard</a>
        </div>
    </form>
</div>
@endsection
