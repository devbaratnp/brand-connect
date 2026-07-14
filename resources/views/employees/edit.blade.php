@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')

    <h1>Edit Employee: {{ $employee->name }}</h1>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="row g-3">

        @csrf
        @method('PUT')

        <div class="col-md-6">
            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $employee->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $employee->email) }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone"
                   class="form-control @error('phone') is-invalid @enderror"
                   value="{{ old('phone', $employee->phone) }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
            <input type="text" name="position" id="position"
                   class="form-control @error('position') is-invalid @enderror"
                   value="{{ old('position', $employee->position) }}">
            @error('position')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="department" class="form-label">Department <span class="text-danger">*</span></label>
            <select name="department" id="department"
                    class="form-select @error('department') is-invalid @enderror">
                <option value="">-- Select --</option>
                @foreach (['IT', 'HR', 'Finance', 'Marketing', 'Sales'] as $dept)
                    <option value="{{ $dept }}"
                        @selected(old('department', $employee->department) == $dept)>
                        {{ $dept }}
                    </option>
                @endforeach
            </select>
            @error('department')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="salary" class="form-label">Salary <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="salary" id="salary"
                   class="form-control @error('salary') is-invalid @enderror"
                   value="{{ old('salary', $employee->salary) }}">
            @error('salary')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="hire_date" class="form-label">Hire Date <span class="text-danger">*</span></label>
            <input type="date" name="hire_date" id="hire_date"
                   class="form-control @error('hire_date') is-invalid @enderror"
                   value="{{ old('hire_date', $employee->hire_date->format('Y-m-d')) }}">
            @error('hire_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <div class="form-check mt-4">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                       value="1" {{ old('is_active', $employee->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Active Employee</label>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Update Employee</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

@endsection
