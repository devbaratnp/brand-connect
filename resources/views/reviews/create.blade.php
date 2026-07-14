@extends('layouts.app')

@section('title', 'Leave Review')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Leave Review</h1>
    <p style="color:var(--bc-text-muted);margin-top:.25rem;">Review your experience with <strong>{{ $campaign->title }}</strong></p>
</div>

<div class="bc-card" style="max-width:640px;">
    <div class="bc-card-header">
        <h2 class="bc-card-title">Your Review</h2>
    </div>
    <div class="bc-divider"></div>

    <form action="{{ route('reviews.store', $campaign) }}" method="POST">
        @csrf

        <div class="bc-form-group">
            <label class="bc-label">Rating</label>
            <div class="bc-flex" style="gap:.5rem;align-items:center;" id="rating-group">
                @for($i = 1; $i <= 5; $i++)
                    <label style="cursor:pointer;font-size:2rem;color:var(--bc-text-muted);transition:color .15s;" class="star-label" data-star="{{ $i }}">
                        <input type="radio" name="rating" value="{{ $i }}" style="display:none;" {{ old('rating') == $i ? 'checked' : '' }}>
                        <span class="star-icon" style="pointer-events:none;">&#9733;</span>
                    </label>
                @endfor
            </div>
            @error('rating')
                <p class="bc-error">{{ $message }}</p>
            @enderror
        </div>

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
            label.style.color = star <= rating ? 'var(--bc-warning, #f59e0b)' : 'var(--bc-text-muted)';
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
