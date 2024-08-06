@extends('adminlte::page')

@section('title', 'Daftar Jaringan')

@section('content_header')
{{-- <h1>Daftar Jaringan</h1> --}}
<h1>Data</h1>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <form action="{{ route('jaringan-atab.index') }}" method="GET">
            <div class="row">
                <div class="col-sm-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-sm-2">
                    <select name="tahun" class="form-control">
                        <option value="">Pilih Tahun</option>
                        @for ($year = 1998; $year <= date('Y'); $year++) <option value="{{ $year }}" {{
                            request('tahun')==$year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                    </select>
                </div>
                <div class="col-sm-2">
                    <select name="satker" class="form-control">
                        <option value="">Pilih Satker</option>
                        <option value="Satker Balai" {{ request('satker')=='Satker Balai' ? 'selected' : '' }}>Satker
                            Balai
                        </option>
                        <option value="Satker PJPA" {{ request('satker')=='Satker PJPA' ? 'selected' : '' }}>Satker PJPA
                        </option>
                        <option value="Satker PJSA" {{ request('satker')=='Satker PJSA' ? 'selected' : '' }}>Satker PJSA
                        </option>
                        <option value="Satker Bendungan" {{ request('satker')=='Satker Bendungan' ? 'selected' : '' }}>
                            Satker Bendungan</option>
                    </select>
                </div>
                <div class="col-sm-1">
                    <button type="submit" class="btn btn-primary btn-block">Cari</button>
                </div>
                <div class="col-sm-4 text-right">
                    <a href="{{ route('jaringan-atab.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Koordinat</th>
                    <th>Tahun</th>
                    <th>Jenis</th>
                    <th>Satker</th>
                    <th>Wilayah Sungai</th>
                    <th>Tahapan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jaringans as $index => $jaringan)
                <tr>
                    <td>{{ $index + 1 + ($jaringans->currentPage() - 1) * $jaringans->perPage() }}</td>
                    <td><a href="{{ route('jaringan-atab.show', $jaringan) }}">{{ $jaringan->nama }}</a></td>
                    <td>{{ $jaringan->latitude }}, {{ $jaringan->longitude }}</td>
                    <td>{{ $jaringan->tahun }}</td>
                    <td><span class="badge badge-info">{{ $jaringan->jenis }}</span></td>
                    <td>{{ $jaringan->satker }}</td>
                    <td>{{ $jaringan->wilayah_sungai }}</td>
                    <td>
                        @if($jaringan->tahapan)
                        @if($jaringan->tahapan == 'Serah Terima Hasil OP')
                        <span class="badge badge-success">{{ $jaringan->tahapan }}</span>
                        @else
                        <span class="badge badge-info">{{ $jaringan->tahapan }}</span>
                        @endif
                        @else
                        <span class="badge badge-danger">Belum Tahapan</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('jaringan-atab.edit', $jaringan) }}" class="btn btn-primary btn-sm"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('jaringan-atab.destroy', $jaringan) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary btn-sm" title="Hapus"
                                onclick="return confirm('Menghapus data ini akan menghapus seluruh data dokumen terkait dan tidak dapat dikembalikan. Apakah Anda yakin ingin melanjutkan?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">Tidak ada data jaringan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $jaringans->links() }}
        </div>
    </div>
</div>
@stop

@section('css')
{{--
<link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

@stop