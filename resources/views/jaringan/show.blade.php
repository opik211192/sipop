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
                <table class="table table-sm table-borderless">
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
                <table class="table table-sm table-borderless">
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
        <table class="table table-bordered table-sm table-hover">
            <thead>
                <tr>
                    <th>Nama Tahapan</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pembentukan Tim</td>
                    <td>
                        @php
                        $tahapanPembentukanTim = $jaringan->tahapans->where('nama_tahapan', 'Pembentukan Tim')->first();
                        $dokumenPembina = $tahapanPembentukanTim ?
                        $tahapanPembentukanTim->dokumens->where('nama_dokumen', 'SK Tim Pembina')->first() : null;
                        $dokumenPelaksana = $tahapanPembentukanTim ?
                        $tahapanPembentukanTim->dokumens->where('nama_dokumen', 'SK Tim Pelaksana')->first() : null;
                        @endphp

                        @if($dokumenPembina && $dokumenPelaksana)
                        <span class="text-success"><i class="fas fa-check-circle"></i> Selesai</span>
                        @else
                        <span class="text-warning"><i class="fas fa-exclamation-circle"></i> Pending</span>
                        @endif
                    </td>
                    <td>
                        @if ($dokumenPembina && $dokumenPelaksana)
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#pembentukan-tim-show">
                            <span class="fas fa-eye" title="Lihat Dokumen"></span></button>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#pembentukan-tim-edit">
                            <span class="fas fa-edit" title="Edit"></span>
                        </button>
                        @else
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#pembentukan-tim">
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Penyusunan Rencana Kerja</td>
                    <td>
                        @php
                        $rencanakerja = $jaringan->tahapans->where('nama_tahapan', 'Penyusunan Rencana Kerja')->first();
                        $dokumenPenyusunanRencanaKerja = $rencanakerja ?
                        $rencanakerja->dokumens->where('nama_dokumen', 'Penyusunan Rencana Kerja')->first() : null;
                        @endphp
                        @if($dokumenPenyusunanRencanaKerja)
                        <span class="text-success"><i class="fas fa-check-circle"></i> Selesai</span>
                        @else
                        <span class="text-warning"><i class="fas fa-exclamation-circle"></i> Pending</span>
                        @endif
                    </td>
                    <td>
                        @if ($dokumenPenyusunanRencanaKerja)
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#penyusunan-rencana-kerja-show">
                            <span class="fas fa-eye" title="Lihat Dokumen"></span>
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#penyusunan-rencana-kerja-edit">
                            <span class="fas fa-edit" title="Edit"></span>
                        </button>
                        @elseif ($dokumenPembina && $dokumenPelaksana)
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#penyusunan-rencana-kerja">
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                        @else
                        <button type="button" class="btn btn-primary btn-sm" disabled>
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Sosialisasi dan Koordinasi</td>
                    <td>
                        @php
                        $soialisai = $jaringan->tahapans->where('nama_tahapan', 'Sosialisasi dan Koordinasi')->first();
                        $dokumenSosialisasi = $soialisai ?
                        $soialisai->dokumens->where('nama_dokumen', 'Sosialisasi dan Koordinasi')->first() : null;
                        @endphp
                        @if($dokumenSosialisasi)
                        <span class="text-success"><i class="fas fa-check-circle"></i> Selesai</span>
                        @else
                        <span class="text-warning"><i class="fas fa-exclamation-circle"></i> Pending</span>
                        @endif
                    </td>
                    <td>
                        @if ($dokumenSosialisasi)
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#sosialisasi-dan-koordinasi-show">
                            <span class="fas fa-eye" title="Lihat Dokumen"></span>
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#sosialisasi-dan-koordinasi-edit">
                            <span class="fas fa-edit" title="Edit"></span>
                        </button>
                        @elseif ($dokumenPenyusunanRencanaKerja)
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#sosialisai-dan-koordiansi">
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                        @else
                        <button type="button" class="btn btn-primary btn-sm" disabled>
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Evaluasi Awal Kesiapan</td>
                    <td>
                        @php
                        $evaluasi = $jaringan->tahapans->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
                        $dokumenExists = $evaluasi &&
                        $evaluasi->dokumens->isNotEmpty();
                        @endphp
                        @if($dokumenExists)
                        <span class="text-success"><i class="fas fa-check-circle"></i> Selesai</span>
                        @else
                        <span class="text-warning"><i class="fas fa-exclamation-circle"></i> Pending</span>
                        @endif
                    </td>
                    <td>
                        @if ($dokumenSosialisasi)
                        <button type="button" class="btn btn-primary btn-sm" id="evaluasi-awal-button">
                            <span class="fas fa-newspaper" title="Evaluasi"></span>
                        </button>
                        @else
                        <button type="button" class="btn btn-primary btn-sm" disabled>
                            <span class="fas fa-newspaper" title="Evaluasi"></span>
                        </button>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Pembentukan Tim -->
<div class="modal fade" id="pembentukan-tim" tabindex="-1" aria-labelledby="pembentukanTimModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pembentukanTimModalLabel">Upload Dokumen Pembentukan Tim</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="formPembentukanTim" action="{{ route('pembentukan-tim.store', $jaringan->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="sk_tim_pembina">SK Tim Pembina</label>
                            <input type="file" accept="application/pdf" class="form-control" id="sk_tim_pembina"
                                name="sk_tim_pembina">
                        </div>
                        <div class="form-group">
                            <label for="sk_tim_pelaksana">SK Tim Pelaksana</label>
                            <input type="file" accept="application/pdf" class="form-control" id="sk_tim_pelaksana"
                                name="sk_tim_pelaksana">
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pembentukan Tim -->
<div class="modal fade" id="pembentukan-tim-edit" tabindex="-1" aria-labelledby="pembentukanTimEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pembentukanTimEditModalLabel">Edit Dokumen Pembentukan Tim</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="formPembentukanTimEdit" action="{{ route('pembentukan-tim.update', $jaringan->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <label for="sk_tim_pembina">SK Tim Pembina</label>
                        <input type="file" accept="application/pdf" class="form-control" id="sk_tim_pembina"
                            name="sk_tim_pembina">
                        <span class="small"><i>Kosongkan jika tidak ubah file</i></span>
                        <div class="form-group mt-3">
                            <label for="sk_tim_pelaksana">SK Tim Pelaksana</label>
                            <input type="file" accept="application/pdf" class="form-control" id="sk_tim_pelaksana"
                                name="sk_tim_pelaksana">
                            <span class="small"><i>Kosongkan jika tidak ubah file</i></span>
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pembentukan Tim Show -->
<div class="modal fade" id="pembentukan-tim-show" tabindex="-1" aria-labelledby="pembentukanTimShowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pembentukanTimShowModalLabel">Dokumen Pembentukan Tim</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="d-flex justify-content-between">
                        @if ($dokumenPembina)
                        <a href="{{ asset('storage/' . substr($dokumenPembina->path_dokumen, 7)) }}" target="_blank"
                            class="btn btn-primary btn-sm">Lihat file SK Tim Pembina</a>
                        @endif
                        @if ($dokumenPelaksana)
                        <a href="{{ asset('storage/' . substr($dokumenPelaksana->path_dokumen, 7)) }}" target="_blank"
                            class="btn btn-primary btn-sm">Lihat file SK Tim Pelaksana</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Penyusunan Rencana Kerja -->
<div class="modal fade" id="penyusunan-rencana-kerja" tabindex="-1" aria-labelledby="penyusunanRencanaKerjaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penyusunanRencanaKerjaModalLabel">Upload Dokumen Penyusunan Rencana Kerja
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="formPenyusunanRencanaKerja"
                        action="{{ route('penyusunan-rencana-kerja.store', $jaringan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="penyusunan_rencana_kerja">Penyusunan Rencana Kerja</label>
                            <input type="file" accept="application/pdf" class="form-control"
                                id="penyusunan_rencana_kerja" name="penyusunan_rencana_kerja">
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Penyusunan Rencana Kerja -->
<div class="modal fade" id="penyusunan-rencana-kerja-edit" tabindex="-1"
    aria-labelledby="penyusunanRencanaKerjaEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penyusunanRencanaKerjaEditModalLabel">Edit Dokumen Penyusunan Rencana Kerja
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="formPenyusunanRencanaKerjaEdit"
                        action="{{ route('penyusunan-rencana-kerja.update', $jaringan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="penyusunan_rencana_kerja">Penyusunan Rencana Kerja</label>
                            <input type="file" accept="application/pdf" class="form-control"
                                id="penyusunan_rencana_kerja" name="penyusunan_rencana_kerja">
                            <span class="small"><i>Kosongkan jika tidak ubah file</i></span>
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show Penysunan Rencana Kerja -->
<div class="modal fade" id="penyusunan-rencana-kerja-show" tabindex="-1"
    aria-labelledby="penyusunanRencanaKerjaShowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penyusunanRencanaKerjaShowModalLabel">Dokumen Penyusunan Rencana Kerja
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="d-flex justify-content-center">
                        @if ($dokumenPenyusunanRencanaKerja)
                        <a href="{{ asset('storage/' . substr($dokumenPenyusunanRencanaKerja->path_dokumen, 7)) }}"
                            target="_blank" class="btn btn-primary btn-sm">Lihat
                            file Penyusunan Rencana Kerja</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sosialisasi dan Koordinasi -->
<div class="modal fade" id="sosialisai-dan-koordiansi" tabindex="-1" aria-labelledby="sosialisasiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sosialisasiModalLabel">Upload Dokumen Sosialisasi dan Koordinasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="formSosialisasiDanKoordinasi"
                        action="{{ route('sosialisasi-koordinasi.store', $jaringan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="dokumen_sosialisasi">Dokumen Sosialisasi dan Koordinasi</label>
                            <input type="file" accept="application/pdf" class="form-control" id="dokumen_sosialisasi"
                                name="dokumen_sosialisasi">
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Sosialisasi dan Koordinasi -->
<div class="modal fade" id="sosialisasi-dan-koordinasi-edit" tabindex="-1" aria-labelledby="sosialisasiEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sosialisasiEditModalLabel">Edit Dokumen Sosialisasi dan Koordinasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="formSosialisasiDanKoordinasiEdit"
                        action="{{ route('sosialisasi-koordinasi.update', $jaringan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- <div class="form-group">
                            @if ($dokumenSosialisasi)
                            <a href="{{ asset('storage/' . substr($dokumenSosialisasi->path_dokumen, 7)) }}"
                                target="_blank" class="btn btn-primary btn-sm">Lihat file Sosialisasi dan Koordinasi</a>
                            @endif
                        </div> --}}
                        <div class="form-group">
                            <label for="dokumen_sosialisasi">Dokumen Sosialisasi dan Koordinasi</label>
                            <input type="file" accept="application/pdf" class="form-control" id="dokumen_sosialisasi"
                                name="dokumen_sosialisasi">
                            <span class="small"><i>Kosongkan jika tidak ubah file</i></span>
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show Sosialisasi dan Koordinasi -->
<div class="modal fade" id="sosialisasi-dan-koordinasi-show" tabindex="-1" aria-labelledby="sosialisasiShowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sosialisasiShowModalLabel">Dokumen Sosialisasi dan Koordinasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    @if ($dokumenSosialisasi)
                    <a href="{{ asset('storage/' . substr($dokumenSosialisasi->path_dokumen, 7)) }}" target="_blank"
                        class="btn btn-primary btn-sm">Lihat file Sosialisasi dan Koordinasi</a>
                    @endif
                </div>
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

        //-----FORM PEMBENTUKAN TIM---------//
        $('#formPembentukanTim').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log("Success:", data);
                    $('#pembentukan-tim').modal('hide');
                    alert('Dokumen berhasil diupload.');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.log("Error:", error);
                    alert('Gagal mengupload dokumen. Silakan coba lagi.');
                }
            });
        });

        //-----FORM EDIT PEMBENTUKAN TIM---------//
        $('#formPembentukanTimEdit').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log("Success:", data);
                    $('#pembentukan-tim-edit').modal('hide');
                    alert('Dokumen berhasil diupdate.');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.log("Error:", error);
                    alert('Gagal mengupdate dokumen. Silakan coba lagi.');
                }
            });
        });


        //-----FORM PENYUSUNAN RENCANA KERJA---------//
        $('#formPenyusunanRencanaKerja').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#penyusunan-rencana-kerja').modal('hide');
                    alert('Dokumen berhasil diupload.');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    alert('Gagal mengupload dokumen. Silakan coba lagi.');
                }
            });
        });

        //-----FORM EDIT PENYUSUNAN RENCANA KERJA---------//
        $('#formPenyusunanRencanaKerjaEdit').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log("Success:", data);
                    $('#penyusunan-rencana-kerja-edit').modal('hide');
                    alert('Dokumen berhasil diperbarui.');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.log("Error:", error);
                    alert('Gagal memperbarui dokumen. Silakan coba lagi.');
                }
            });
        });

        //-----FORM SOSIALISASI DAN KOORDINASI---------//
        $('#formSosialisasiDanKoordinasi').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#sosialisai-dan-koordiansi').modal('hide');
                    alert('Dokumen berhasil diupload.');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    alert('Gagal mengupload dokumen. Silakan coba lagi.');
                }
            });
        });

        //-----FORM EDIT SOSIALISASI DAN KOORDINASI---------//
        $('#formSosialisasiDanKoordinasiEdit').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log("Success:", data);
                    $('#sosialisasi-dan-koordinasi-edit').modal('hide');
                    alert('Dokumen berhasil diperbarui.');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.log("Error:", error);
                    alert('Gagal memperbarui dokumen. Silakan coba lagi.');
                }
            });
        });


        document.getElementById('evaluasi-awal-button').addEventListener('click', function() {
            var url = "{{ route('evaluasi-awal', ['jaringan' => $jaringan->id]) }}";
            window.open(url, '_blank', 'width=800,height=600,resizable=no');
        });
    });
</script>
@stop