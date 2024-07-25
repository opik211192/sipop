@extends('adminlte::page')

@section('title', 'Create User')

@section('content_header')
<h1>Tambah User</h1>
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
            <h3 class="card-title">Kolom User Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
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
        var errorAlert = $('#error-alert');

        if (errorAlert.length) {
            errorAlert.fadeTo(5000, 0, function() {
                $(this).slideUp(500, function() {
                    $(this).remove();
                });
            });
        }
    });
</script>
@stop