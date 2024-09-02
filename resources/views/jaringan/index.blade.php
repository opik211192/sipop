@extends('adminlte::page')

@section('title', 'Daftar Jaringan')

@section('content_header')
<h1 class="font-weight-bold">Data Paket</h1>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-8">
                <form action="{{ route('jaringan-atab.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama..."
                            value="{{ request('search') }}">
                        <select name="tahun" class="form-control mx-2">
                            <option value="">Pilih Tahun</option>
                            @for ($year = 1998; $year <= date('Y'); $year++) <option value="{{ $year }}" {{
                                request('tahun')==$year ? 'selected' : '' }}>
                                {{ $year }}
                                </option>
                                @endfor
                        </select>
                        <select name="satker" class="form-control">
                            <option value="">Pilih Satker</option>
                            <option value="Satker Balai" {{ request('satker')=='Satker Balai' ? 'selected' : '' }}>
                                Satker
                                Balai</option>
                            <option value="Satker PJPA" {{ request('satker')=='Satker PJPA' ? 'selected' : '' }}>Satker
                                PJPA
                            </option>
                            <option value="Satker PJSA" {{ request('satker')=='Satker PJSA' ? 'selected' : '' }}>Satker
                                PJSA
                            </option>
                            <option value="Satker Bendungan" {{ request('satker')=='Satker Bendungan' ? 'selected' : ''
                                }}>
                                Satker Bendungan</option>
                        </select>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('jaringan-atab.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-4 text-right">
                @can('create paket')
                <a href="{{ route('jaringan-atab.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> Tambah Paket
                </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered table-striped table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <th style="width: 5%">#</th>
                    <th>Nama</th>
                    <th>Koordinat</th>
                    <th>Tahun</th>
                    <th>Jenis</th>
                    <th>Satker</th>
                    <th>Wilayah Sungai</th>
                    <th>Tahapan</th>
                    @can('edit paket')
                        
                    <th style="width: 15%">Aksi</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @forelse($jaringans as $index => $jaringan)
                <tr>
                    <td>{{ $index + 1 + ($jaringans->currentPage() - 1) * $jaringans->perPage() }}</td>
                    <td><a href="{{ route('jaringan-atab.show', $jaringan) }}">{{ $jaringan->nama }}</a></td>
                    <td>{{ $jaringan->latitude }}, {{ $jaringan->longitude }}</td>
                    <td>{{ $jaringan->tahun }}</td>
                    <td><span class="badge bg-info">{{ $jaringan->jenis }}</span></td>
                    <td>{{ $jaringan->satker }}</td>
                    <td>{{ $jaringan->wilayah_sungai }}</td>
                    <td>
                        @if($jaringan->tahapan)
                        @if($jaringan->tahapan == 'Serah Terima hasil OP')
                        <span class="badge bg-success">{{ $jaringan->tahapan }}</span>
                        @else
                        <span class="badge bg-info">{{ $jaringan->tahapan }}</span>
                        @endif
                        @else
                        <span class="badge bg-danger">Belum Tahapan</span>
                        @endif
                    </td>
                    @can('edit paket')
                    <td>
                        <a href="{{ route('jaringan-atab.edit', $jaringan) }}" class="btn btn-primary btn-sm"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        @can('delete paket')
                        <form action="{{ route('jaringan-atab.destroy', $jaringan) }}" method="POST"
                        style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                        onclick="return confirm('Menghapus data ini akan menghapus seluruh data dokumen terkait dan tidak dapat dikembalikan. Apakah Anda yakin ingin melanjutkan?')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
                @endcan
            </td>
            @endcan 
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data jaringan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        <div class="d-flex justify-content-center">
            {{ $jaringans->links() }}
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }

    .badge {
        font-size: 90%;
    }

    .btn-sm {
        font-size: 0.875rem;
    }

    .form-control {
        height: calc(2.25rem + 2px);
    }
</style>
@stop

@section('js')
{{-- Custom JavaScript here --}}
@stop