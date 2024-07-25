@extends('adminlte::page')

@section('title', 'Assign Permissions to Role')

@section('content_header')
<h1>Assign Permissions to Role</h1>
@stop

@section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-header">Assign Permissions</div>
    <div class="card-body">
        <form action="{{ route('assign.permissions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="">Select Role</option>
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="permissions">Permissions</label>
                <div id="permissions">
                    @foreach ($permissions as $permission)
                    <div class="form-check">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                            class="form-check-input" id="permission-{{ $permission->id }}">
                        <label class="form-check-label" for="permission-{{ $permission->id }}">{{ $permission->name
                            }}</label>
                    </div>
                    @endforeach
                </div>
                @error('permissions')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Assign Permissions</button>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">Roles and Their Permissions</div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach ($role->permissions as $permission)
                        <span class="badge bg-secondary">{{ $permission->name }}</span>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop