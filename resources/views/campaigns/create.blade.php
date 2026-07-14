@extends('layouts.app')

@section('title', 'Create Campaign')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Create Campaign</h1>
</div>

<div class="bc-card" style="max-width:720px;">
    <div class="bc-card-header">
        <h2 class="bc-card-title">Campaign Details</h2>
    </div>
    <div class="bc-divider"></div>

    <form action="{{ route('campaigns.store') }}" method="POST">
        @csrf

        <div class="bc-form-group">
            <label class="bc-label" for="title">Title</label>
            <input type="text" name="title" id="title" class="bc-input" value="{{ old('title') }}" placeholder="Enter campaign title" required>
            @error('title')
                <p class="bc-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="bc-form-group">
            <label class="bc-label" for="description">Description</label>
            <textarea name="description" id="description" class="bc-input" rows="5" placeholder="Describe your campaign..." required>{{ old('description') }}</textarea>
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
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                <input type="number" name="budget" id="budget" class="bc-input" value="{{ old('budget') }}" min="0" step="0.01" placeholder="0.00" required>
                @error('budget')
                    <p class="bc-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="bc-form-group">
            <label class="bc-label" for="deadline">Deadline</label>
            <input type="date" name="deadline" id="deadline" class="bc-input" value="{{ old('deadline') }}" required>
            @error('deadline')
                <p class="bc-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="bc-form-group">
            <label class="bc-label" for="requirements">Requirements</label>
            <textarea name="requirements" id="requirements" class="bc-input" rows="4" placeholder="Any specific requirements for creators...">{{ old('requirements') }}</textarea>
            @error('requirements')
                <p class="bc-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="bc-flex" style="justify-content:flex-end;gap:.75rem;margin-top:1rem;">
            <a href="{{ route('campaigns.index') }}" class="bc-btn bc-btn-ghost">Cancel</a>
            <button type="submit" class="bc-btn bc-btn-primary">Create Campaign</button>
        </div>
    </form>
</div>
@endsection
