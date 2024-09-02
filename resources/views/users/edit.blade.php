@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
<h1>Edit User</h1>
@stop

@section('content')
@if ($errors->any())
<div class="alert alert-danger" id="error-alert">
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
            <h3 class="card-title">Edit User</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control">
                    <small>Kosongkan jika tidak ingin mengubah password</small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <div class="form-group">
                    <label for="jabatan_id">Jabatan</label>
                    <select name="jabatan_id" id="jabatan_id" class="form-control">
                        <option value="">Pilih Jabatan</option>
                        @foreach($jabatans as $jabatan)
                        <option value="{{ $jabatan->id }}" {{ $user->jabatan_id == $jabatan->id ? 'selected' : '' }}>
                            {{ $jabatan->nama_jabatan }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="jabatan_detail_id">Detail Jabatan</label>
                    <select name="jabatan_detail_id" id="jabatan_detail_id" class="form-control">
                        <option value="">Pilih Detail Jabatan</option>
                        @foreach($jabatanDetails as $detail)
                        <option value="{{ $detail->id }}" {{ $user->jabatan_detail_id == $detail->id ? 'selected' : ''
                            }}>
                            {{ $detail->nama_detail }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">Batal</a>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#jabatan_id').on('change', function() {
            var jabatanID = $(this).val();
            if(jabatanID) {
                $.ajax({
                    url: '/users/getJabatanDetails/' + jabatanID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('#jabatan_detail_id').empty();
                        $('#jabatan_detail_id').append('<option value="">Pilih Detail Jabatan</option>');
                        $.each(data, function(key, value) {
                            $('#jabatan_detail_id').append('<option value="'+ value.id +'">'+ value.nama_jabatan_detail +'</option>');
                        });
                    }
                });
            } else {
                $('#jabatan_detail_id').empty();
                $('#jabatan_detail_id').append('<option value="">Pilih Detail Jabatan</option>');
            }
        });
    });
</script>
@stop