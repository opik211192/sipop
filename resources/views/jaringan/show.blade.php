@extends('adminlte::page')

@section('title', 'Detail Jaringan')

@section('content_header')
<h1>Detail Jaringan</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Informasi Jaringan</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $jaringan->nama }}</td>
                        </tr>
                        <tr>
                            <th>Koordinat</th>
                            <td>{{ $jaringan->latitude }}, {{ $jaringan->longitude }}</td>
                        </tr>
                        <tr>
                            <th>Provinsi</th>
                            <td>{{ $jaringan->province ? ucwords(strtolower($jaringan->province->name)) : 'Tidak
                                tersedia' }}</td>
                        </tr>
                        <tr>
                            <th>Kota/Kabupaten</th>
                            <td>{{ $jaringan->city ? ucwords(strtolower($jaringan->city->name)) : 'Tidak tersedia' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Kecamatan</th>
                            <td>{{ $jaringan->district ? ucwords(strtolower($jaringan->district->name)) : 'Tidak
                                tersedia' }}</td>
                        </tr>
                        <tr>
                            <th>Desa</th>
                            <td>{{ $jaringan->village ? ucwords(strtolower($jaringan->village->name)) : 'Tidak tersedia'
                                }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-6">
                <table class="table table-striped table-bordered table-sm">
                    <tbody>
                        <tr>
                            <th>Wilayah Sungai</th>
                            <td>{{ $jaringan->wilayah_sungai }}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>{{ $jaringan->jenis }}</td>
                        </tr>
                        <tr>
                            <th>Tahun</th>
                            <td>{{ $jaringan->tahun }}</td>
                        </tr>
                        <tr>
                            <th>Satker</th>
                            <td>{{ $jaringan->satker }}</td>
                        </tr>
                        <tr>
                            <th>Tahapan</th>
                            <td>
                                @if($jaringan->tahapan)
                                {{ $jaringan->tahapan }}
                                @else
                                <span class="badge bg-danger">Belum Tahapan</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Persiapan Operasi Pemeliharaan</h3>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pembentukan-tim-tab" data-toggle="tab" href="#pembentukan-tim" role="tab"
                    aria-controls="pembentukan-tim" aria-selected="true">Pembentukan Tim</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="rencana-kerja-tab" data-toggle="tab" href="#rencana-kerja" role="tab"
                    aria-controls="rencana-kerja" aria-selected="false">Penyusunan Rencana Kerja</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="sosialisasi-tab" data-toggle="tab" href="#sosialisasi" role="tab"
                    aria-controls="sosialisasi" aria-selected="false">Sosialisasi dan Koordinasi</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pembentukan-tim" role="tabpanel"
                aria-labelledby="pembentukan-tim-tab">
                <h1>Loading...</h1>
            </div>
            <div class="tab-pane fade" id="rencana-kerja" role="tabpanel" aria-labelledby="rencana-kerja-tab">
                <h1>Loading...</h1>
            </div>
            <div class="tab-pane fade" id="sosialisasi" role="tabpanel" aria-labelledby="sosialisasi-tab">
                <h1>Loading...</h1>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('jaringan-atab.index') }}" class="btn btn-primary">Kembali ke Daftar</a>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    $(document).ready(function () {
        $('#myTab a').on('click', function (e) {
            e.preventDefault();
            var tabId = $(this).attr('href');
            $(this).tab('show');

            if ($(tabId).html() === '<h1>Loading...</h1>') {
                $.ajax({
                    url: tabId + '-content',
                    method: 'GET',
                    success: function (data) {
                        $(tabId).html(data);
                    },
                    error: function (xhr, status, error) {
                        $(tabId).html('<h1>Error loading content</h1>');
                    }
                });
            }
        });

        // Load the initial tab content
        $('#myTab a.active').trigger('click');
    });
</script>
@stop