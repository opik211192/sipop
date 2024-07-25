@extends('adminlte::page')

@section('title', 'Daftar Jaringan')

@section('content_header')
<h1>Daftar Jaringan</h1>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <a href="{{ route('jaringan-atab.create') }}" class="btn btn-primary mb-3">Tambah Jaringan</a>
        <form action="{{ route('jaringan-atab.index') }}" method="GET">
            <div class="row">
                <div class="col-sm-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ $search }}">
                </div>
                <div class="col-sm-1">
                    <button type="submit" class="btn btn-primary btn-block">Cari</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Provinsi</th>
                    <th>Kota/Kabupaten</th>
                    <th>Kecamatan</th>
                    <th>Desa</th>
                    <th>Tahapan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jaringans as $index => $jaringan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->latitude }}</td>
                    <td>{{ $item->longitude }}</td>
                    <td>{{ $item->province->name ?? '-' }}</td>
                    <td>{{ $item->city->name ?? '-' }}</td>
                    <td>{{ $item->district->name ?? '-' }}</td>
                    <td>{{ $item->village->name ?? '-' }}</td>
                    <td>{{ $item->tahapan ? $item->tahapan : 'Belum Tahapan' }}</td>
                    </td>
                    <td>
                        <a href="{{ route('jaringan-atab.edit', $jaringan) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('jaringan-atab.destroy', $jaringan) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Anda yakin ingin menghapus jaringan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">Tidak ada data jaringan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $jaringan->links() }}
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log('Hi!'); 
</script>
@stop