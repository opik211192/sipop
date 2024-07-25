@extends('adminlte::page')

@section('title', 'Assign Roles to Users')

@section('content_header')
<h1>Assign Roles to Users</h1>
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
    <div class="card-header">Assign Roles</div>
    <div class="card-body">
        <form action="{{ route('assign.users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="user">User</label>
                <select name="user" id="user" class="form-control" required>
                    <option value="">Select User</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="roles">Roles</label>
                <div id="roles">
                    @foreach ($roles as $role)
                    <div class="form-check">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-check-input"
                            id="role-{{ $role->id }}">
                        <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name }}</label>
                    </div>
                    @endforeach
                </div>
                @error('roles')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Assign Roles</button>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">Users and Their Roles</div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Roles</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>
                        @foreach ($user->roles as $role)
                        <span class="badge bg-secondary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <form action="{{ route('assign.users.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user" value="{{ $user->id }}">
                            <div id="roles">
                                @foreach ($roles as $role)
                                <div class="form-check">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                        class="form-check-input" id="role-{{ $role->id }}-{{ $user->id }}" {{
                                        $user->roles->contains($role) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role-{{ $role->id }}-{{ $user->id }}">{{
                                        $role->name }}</label>
                                </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary mt-2">Update Roles</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop