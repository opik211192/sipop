@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
<h1>Roles</h1>
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

<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Role List</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#createRoleModal"><span class="fas fa-plus" title="Add Role"></span></button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Guard Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="roleTable">
                    @foreach ($roles as $role)
                    <tr id="roleRow{{ $role->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->guard_name }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="editRole({{ $role->id }})">
                                <span class="fas fa-edit" title="Edit"></span>
                            </button>
                            <button class="btn btn-sm btn-dark" onclick="deleteRole({{ $role->id }})">
                                <span class="fas fa-trash" title="Delete"></span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRoleModalLabel">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createRoleForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="roleName">Role Name</label>
                        <input type="text" id="roleName" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="guardName">Guard Name</label>
                        <input type="text" id="guardName" name="guard_name" class="form-control" value="web">
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


<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="editRoleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editRoleForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editRoleId" name="role_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editRoleName">Role Name</label>
                        <input type="text" id="editRoleName" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editGuardName">Guard Name</label>
                        <input type="text" id="editGuardName" name="guard_name" class="form-control" readonly>
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
    // Handle Create Role Form Submission
    $('#createRoleForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '{{ route("roles.store") }}',
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log('Response:', response); // Debugging line
                $('#createRoleModal').modal('hide');
                $('#createRoleForm')[0].reset();
                $('#roleTable').append(`
                    <tr id="roleRow${response.role.id}">
                        <td>${response.role.id}</td>
                        <td>${response.role.name}</td>
                        <td>${response.role.guard_name}</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="editRole(${response.role.id})">
                                <span class="fas fa-edit" title="Edit"></span>
                            </button>
                            <button class="btn btn-sm btn-dark" onclick="deleteRole(${response.role.id})">
                                <span class="fas fa-trash" title="Delete"></span>
                            </button>
                        </td>
                    </tr>
                `);
            },
            error: function (xhr) {
                console.log('Error:', xhr.responseText); // Debugging line
            }
        });
    });

    // Handle Delete Role
    function deleteRole(roleId) {
        if (confirm('Hapus Data ini ?')) {
            $.ajax({
                url: '/roles/' + roleId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('#roleRow' + roleId).remove();
                    alert(response.success);
                },
                error: function (xhr) {
                    console.log('Error:', xhr.responseText); // Debugging line
                }
            });
        }
    }

    // Handle Edit Role
function editRole(roleId) {
    $.ajax({
        url: '/roles/' + roleId + '/edit',
        type: 'GET',
        success: function (response) {
            $('#editRoleId').val(response.id);
            $('#editRoleName').val(response.name);
            $('#editGuardName').val(response.guard_name);
            $('#editRoleModal').modal('show');
        },
        error: function (xhr) {
            console.log('Error:', xhr.responseText);
        }
    });
}

// Handle Edit Role Form Submission
$('#editRoleForm').on('submit', function (e) {
    e.preventDefault();
    var roleId = $('#editRoleId').val();
    var formData = $(this).serialize();
    $.ajax({
        url: '/roles/' + roleId,
        type: 'PUT',
        data: formData,
        success: function (response) {
            $('#editRoleModal').modal('hide');
            $('#roleRow' + roleId).replaceWith(`
                <tr id="roleRow${response.role.id}">
                    <td>${response.role.id}</td>
                    <td>${response.role.name}</td>
                    <td>${response.role.guard_name}</td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="editRole(${response.role.id})">
                            <span class="fas fa-edit" title="Edit"></span>
                        </button>
                        <button class="btn btn-sm btn-dark" onclick="deleteRole(${response.role.id})">
                            <span class="fas fa-trash" title="Delete"></span>
                        </button>
                    </td>
                </tr>
            `);
        },
        error: function (xhr) {
            console.log('Error:', xhr.responseText);
        }
    });
});

</script>
@stop