@extends('adminlte::page')

@section('title', 'Permissions')

@section('content_header')
<h1>Permissions</h1>
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

<div class="col-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Permissions List</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#createPermissionModal">
                    <span class="fas fa-plus" title="Add Permission"></span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover" id="permissionsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                    <tr id="permission-{{ $permission->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>
                            <button class="btn btn-sm btn-info edit-permission" data-id="{{ $permission->id }}"
                                data-name="{{ $permission->name }}">
                                <span class="fas fa-edit" title="edit"></span>
                            </button>
                            <button class="btn btn-sm btn-dark delete-permission" data-id="{{ $permission->id }}">
                                <span class="fas fa-trash" title="delete"></span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Permission Modal -->
<div class="modal fade" id="createPermissionModal" tabindex="-1" role="dialog"
    aria-labelledby="createPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPermissionModalLabel">Add New Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createPermissionForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="permissionName">Permission Name</label>
                        <input type="text" name="name" class="form-control" id="permissionName" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Permission Modal -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" role="dialog" aria-labelledby="editPermissionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPermissionModalLabel">Edit Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPermissionForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editPermissionName">Permission Name</label>
                        <input type="text" name="name" class="form-control" id="editPermissionName" required>
                        <input type="hidden" id="editPermissionId">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('js')
<script>
    $(document).ready(function() {
        // Create Permission AJAX
        $('#createPermissionForm').submit(function(e) {
            e.preventDefault();
            var name = $('#permissionName').val();
            $.ajax({
                url: '{{ route("permissions.store") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name
                },
                success: function(response) {
                    $('#permissionsTable tbody').append('<tr id="permission-' + response.id + '"><td>' + (response.id) + '</td><td>' + response.name + '</td><td><button class="btn btn-sm btn-info edit-permission" data-id="' + response.id + '" data-name="' + response.name + '"><span class="fas fa-edit" title="edit"></span></button> <button class="btn btn-sm btn-dark delete-permission" data-id="' + response.id + '"><span class="fas fa-trash" title="delete"></span></button></td></tr>');
                    $('#createPermissionModal').modal('hide');
                    $('#permissionName').val('');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        // Edit Permission Button Click
        $(document).on('click', '.edit-permission', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#editPermissionId').val(id);
            $('#editPermissionName').val(name);
            $('#editPermissionModal').modal('show');
        });

        // Update Permission AJAX
        $('#editPermissionForm').submit(function(e) {
            e.preventDefault();
            var id = $('#editPermissionId').val();
            var name = $('#editPermissionName').val();
            $.ajax({
                url: '/permissions/' + id,
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name
                },
                success: function(response) {
                    $('#permission-' + response.id).find('td:nth-child(2)').text(response.name);
                    $('#editPermissionModal').modal('hide');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        // Delete Permission AJAX
        $(document).on('click', '.delete-permission', function() {
            if (!confirm('Hapus data ini ?')) return;
            var id = $(this).data('id');
            $.ajax({
                url: '/permissions/' + id,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#permission-' + id).remove();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@stop