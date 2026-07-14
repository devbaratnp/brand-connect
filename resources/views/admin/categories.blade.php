@extends('layouts.app')

@section('title', 'Manage Categories')

@section('content')
<div class="bc-page-header">
    <h1 class="bc-page-title">Manage Categories</h1>
</div>

<div class="bc-grid-2" style="gap: 2rem;">
    <div class="bc-card">
        <div class="bc-card-header">
            <h2 class="bc-card-title">Add Category</h2>
        </div>

        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf

            <div class="bc-form-group">
                <label class="bc-label" for="name">Name</label>
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
                <label class="bc-label" for="slug">Slug</label>
                <input
                    type="text"
                    id="slug"
                    name="slug"
                    class="bc-input @error('slug') bc-input-error @enderror"
                    value="{{ old('slug') }}"
                    placeholder="auto-generated-from-name"
                >
                @error('slug')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="bc-form-group">
                <label class="bc-label" for="description">Description</label>
                <input
                    type="text"
                    id="description"
                    name="description"
                    class="bc-input @error('description') bc-input-error @enderror"
                    value="{{ old('description') }}"
                >
                @error('description')
                    <span class="bc-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="bc-btn bc-btn-success">
                Add Category
            </button>
        </form>
    </div>

    <div class="bc-card">
        <div class="bc-card-header">
            <h2 class="bc-card-title">All Categories</h2>
        </div>
        <div class="bc-table-wrap">
            <table class="bc-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Creators</th>
                        <th>Campaigns</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>{{ $category->creators_count ?? $category->creators->count() ?? 0 }}</td>
                            <td>{{ $category->campaigns_count ?? $category->campaigns->count() ?? 0 }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bc-btn bc-btn-danger bc-btn-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="bc-empty">
                                    <div class="bc-empty-icon">🏷️</div>
                                    <div class="bc-empty-text">No categories yet</div>
                                    <div class="bc-empty-sub">Add your first category using the form.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
