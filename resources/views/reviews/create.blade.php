@extends('layouts.app')

@section('title', 'Leave Review')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Leave Review</h1>
    <p style="color:var(--muted);margin-top:.25rem;">Review your experience with <strong>{{ $campaign->title }}</strong>@if($reviewee) — reviewing <strong>{{ $reviewee->name }}</strong>@endif</p>
</div>

<div class="bc-card" style="max-width:640px;">
    <div class="bc-card-header">
        <h2 class="bc-card-title">Your Review</h2>
    </div>
    <div class="bc-divider"></div>

    <form action="{{ route('reviews.store', $campaign) }}" method="POST">
        @csrf
        @if($reviewee)
            <input type="hidden" name="reviewee_id" value="{{ $reviewee->id }}">
        @endif

        <fieldset class="bc-form-group" style="border:none;padding:0;margin:0 0 20px;">
            <legend class="bc-label" style="padding:0;">Rating (1 to 5 stars)</legend>
            <div class="bc-flex" style="gap:.5rem;align-items:center;" id="rating-group">
                @for($i = 1; $i <= 5; $i++)
                    <label style="cursor:pointer;font-size:2rem;color:var(--muted);transition:color .15s;" class="star-label" data-star="{{ $i }}">
                        <input type="radio" name="rating" value="{{ $i }}" class="bc-sr-only" {{ old('rating') == $i ? 'checked' : '' }}>
                        <span class="star-icon" style="pointer-events:none;" aria-hidden="true">&#9733;</span>
                    </label>
                @endfor
            </div>
            @error('rating')
                <p class="bc-error">{{ $message }}</p>
            @enderror
        </fieldset>

        <div class="bc-form-group">
            <label class="bc-label" for="review">Review</label>
            <textarea name="review" id="review" class="bc-input" rows="5" placeholder="Share your experience working on this campaign..." required>{{ old('review') }}</textarea>
            @error('review')
                <p class="bc-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="bc-flex" style="justify-content:flex-end;gap:.75rem;margin-top:1rem;">
            <a href="{{ route('campaigns.show', $campaign) }}" class="bc-btn bc-btn-ghost">Cancel</a>
            <button type="submit" class="bc-btn bc-btn-primary">Submit Review</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const group = document.getElementById('rating-group');
    const labels = group.querySelectorAll('.star-label');
    let currentRating = parseInt(group.querySelector('input:checked')?.value || 0);

    function updateStars(rating) {
        labels.forEach(function(label) {
            const star = parseInt(label.dataset.star);
            label.style.color = star <= rating ? '#f59e0b' : 'var(--muted)';
        });
    }

    updateStars(currentRating);

    labels.forEach(function(label) {
        label.addEventListener('mouseenter', function() {
            updateStars(parseInt(this.dataset.star));
        });
        label.addEventListener('mouseleave', function() {
            updateStars(currentRating);
        });
        label.addEventListener('click', function() {
            currentRating = parseInt(this.dataset.star);
            updateStars(currentRating);
        });
    });
});
</script>
@endsection
