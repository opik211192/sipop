@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')
{{-- Tambahkan CSS tambahan jika diperlukan --}}
@stop

@section('js')
<script>
    console.log("Custom dashboard script!"); 
</script>
@stop