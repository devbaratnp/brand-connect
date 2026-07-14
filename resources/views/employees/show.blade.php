@extends('layouts.app')

@section('title', $employee->name)

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>{{ $employee->name }}</h1>
        <div>
            <a href="{{ route('employees.edit', $employee->id) }}"
               class="btn btn-warning">Edit</a>
            <a href="{{ route('employees.index') }}"
               class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Employee Information
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width:200px">ID</th>
                    <td>{{ $employee->id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $employee->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $employee->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $employee->phone ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Position</th>
                    <td>{{ $employee->position }}</td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td>{{ $employee->department }}</td>
                </tr>
                <tr>
                    <th>Salary</th>
                    <td>${{ number_format($employee->salary, 2) }}</td>
                </tr>
                <tr>
                    <th>Hire Date</th>
                    <td>{{ $employee->hire_date->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($employee->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $employee->created_at->format('M d, Y h:i A') }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $employee->updated_at->format('M d, Y h:i A') }}</td>
                </tr>
            </table>
        </div>
    </div>

@endsection
