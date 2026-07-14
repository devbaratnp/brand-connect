@extends('layouts.app')

@section('title', 'Employees List')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Employees</h1>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">+ Add Employee</a>
    </div>

    @if ($employees->isEmpty())
        <div class="alert alert-info">
            No employees found. <a href="{{ route('employees.create') }}">Add the first one!</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Salary</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->department }}</td>
                            <td>${{ number_format($employee->salary, 2) }}</td>
                            <td>
                                @if ($employee->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('employees.show', $employee->id) }}"
                                   class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('employees.edit', $employee->id) }}"
                                   class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('employees.destroy', $employee->id) }}"
                                      method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

@endsection
