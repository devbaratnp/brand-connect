@extends('layouts.app')

@section('title', 'Edit Campaign')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Edit Campaign</h1>
</div>

<div class="bc-card" style="max-width:720px;">
    <div class="bc-card-header">
        <h2 class="bc-card-title">{{ $campaign->title }}</h2>
    </div>
    <div class="bc-divider"></div>

    <form action="{{ route('campaigns.update', $campaign) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bc-form-group">
            <label class="bc-label" for="title">Title</label>
            <input type="text" name="title" id="title" class="bc-input" value="{{ old('title', $campaign->title) }}" required>
            @error('title')
                <p class="bc-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="bc-form-group">
            <label class="bc-label" for="description">Description</label>
            <textarea name="description" id="description" class="bc-input" rows="5" required>{{ old('description', $campaign->description) }}</textarea>
            @error('description')
                <p class="bc-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="bc-grid-2">
            <div class="bc-form-group">
                <label class="bc-label" for="category_id">Category</label>
                <select name="category_id" id="category_id" class="bc-input" required>
                    <option value="">Select category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $campaign->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="bc-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="bc-form-group">
                <label class="bc-label" for="budget">Budget (Rs.)</label>
                <input type="number" name="budget" id="budget" class="bc-input" value="{{ old('budget', $campaign->budget) }}" min="0" step="0.01" required>
                @error('budget')
                    <p class="bc-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="bc-grid-2">
            <div class="bc-form-group">
                <label class="bc-label" for="deadline">Deadline</label>
                <input type="date" name="deadline" id="deadline" class="bc-input" value="{{ old('deadline', $campaign->deadline ? \Carbon\Carbon::parse($campaign->deadline)->format('Y-m-d') : '') }}" required>
                @error('deadline')
                    <p class="bc-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="bc-form-group">
                <label class="bc-label" for="status">Status</label>
                <select name="status" id="status" class="bc-input" required>
                    @foreach(['open' => 'Open', 'in_progress' => 'In Progress', 'closed' => 'Closed', 'cancelled' => 'Cancelled'] as $value => $label)
                        <option value="{{ $value }}" {{ old('status', $campaign->status) === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="bc-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="bc-form-group">
            <label class="bc-label" for="requirements">Requirements</label>
            <textarea name="requirements" id="requirements" class="bc-input" rows="4">{{ old('requirements', $campaign->requirements) }}</textarea>
            @error('requirements')
                <p class="bc-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="bc-flex" style="justify-content:flex-end;gap:.75rem;margin-top:1rem;">
            <a href="{{ route('campaigns.show', $campaign) }}" class="bc-btn bc-btn-ghost">Cancel</a>
            <button type="submit" class="bc-btn bc-btn-primary">Update Campaign</button>
        </div>
    </form>
</div>
@endsection
