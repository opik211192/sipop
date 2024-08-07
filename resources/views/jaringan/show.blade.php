@extends('adminlte::page')

@section('title', 'Detail Jaringan')

@section('content_header')
<h1>Detail</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Informasi Data</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-4">
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
                        <tr>
                            <th>Tahapan</th>
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
                        $dokumenPenyusunanRencanaKerja = $rencanakerja ? $rencanakerja->dokumens->where('nama_dokumen',
                        'Penyusunan Rencana Kerja')->first() : null;
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
                        $dokumenSosialisasi = $soialisai ? $soialisai->dokumens->where('nama_dokumen', 'Sosialisasi dan
                        Koordinasi')->first() : null;
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
                    <td colspan="3">
                        Penyusunan Evaluasi Awal Kesiapan<br>
                        <a data-toggle="collapse" href="#collapseInventarisasi" role="button" aria-expanded="false"
                            aria-controls="collapseInventarisasi">
                            Inventarisasi Data dan Informasi dan Evaluasi Awal Kesiapan OP
                            <i class="fas fa-chevron-down ml-1 text-primary"></i>
                        </a>
                        <div class="collapse show" id="collapseInventarisasi">
                            <div class="card card-body">
                                <div class="container mt-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="nav flex-column nav-tabs" id="v-tabs" role="tablist"
                                                aria-orientation="vertical">
                                                <a class="nav-link active" id="v-tabs-home-tab" data-toggle="pill"
                                                    href="#v-tabs-home" role="tab" aria-controls="v-tabs-home"
                                                    aria-selected="true">Data dan Informasi Pekerjaan Fisik</a>
                                                <a class="nav-link" id="v-tabs-profile-tab" data-toggle="pill"
                                                    href="#v-tabs-profile" role="tab" aria-controls="v-tabs-profile"
                                                    aria-selected="false">Data dan Informasi Non-Fisik</a>
                                                <a class="nav-link" id="v-tabs-messages-tab" data-toggle="pill"
                                                    href="#v-tabs-messages" role="tab" aria-controls="v-tabs-messages"
                                                    aria-selected="false">Sarana dan Prasarana Pendukung</a>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="tab-content" id="v-tabs-tabContent">
                                                <div class="tab-pane fade show active" id="v-tabs-home" role="tabpanel"
                                                    aria-labelledby="v-tabs-home-tab">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $evaluasiAwal = $jaringan->tahapans->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
                                                                // Evaluasi Blanko berdasarkan jenis jaringan
                                                                $evaluasiBlanko1A = $evaluasiAwal ? $evaluasiAwal->evaluasiBlankos->where('jenis_blanko', 'Blanko 1A')->first() : null;
                                                                $allPrasaranaAirTanahFilled = $evaluasiBlanko1A && $evaluasiBlanko1A->items->every(function ($item) {
                                                                    return !empty($item->ada_tidak_ada) && !empty($item->kondisi) && !empty($item->fungsi) && !empty($item->keterangan);
                                                                });

                                                                $evaluasiBlanko1B = $evaluasiAwal ? $evaluasiAwal->evaluasiBlankos->where('jenis_blanko', 'Blanko 1B')->first() : null;
                                                                $allPeralatanAirTanahFilled = $evaluasiBlanko1B && $evaluasiBlanko1B->items->isNotEmpty() && $evaluasiBlanko1B->items->every(function ($item) {
                                                                    return !empty($item->ada_tidak_ada) && !empty($item->kondisi) && !empty($item->fungsi) && !empty($item->keterangan);
                                                                });

                                                                $evaluasiBlanko1C = $evaluasiAwal ? $evaluasiAwal->evaluasiBlankos->where('jenis_blanko', 'Blanko 1C')->first() : null;
                                                                $allPrasaranaAirBakuEmbungFilled = $evaluasiBlanko1C && $evaluasiBlanko1C->items->isNotEmpty() && $evaluasiBlanko1C->items->every(function ($item) {
                                                                    return !empty($item->ada_tidak_ada) && !empty($item->kondisi) && !empty($item->fungsi) && !empty($item->keterangan);
                                                                });
                                                            ?>
                                                            @if ($jaringan->jenis == 'Air Tanah')
                                                            <tr>
                                                                <td>Prasarana Air Tanah</td>
                                                                <td>
                                                                    @if($allPrasaranaAirTanahFilled)
                                                                    <span class="text-success"><i
                                                                            class="fas fa-check-circle"></i>
                                                                        Selesai</span>
                                                                    @else
                                                                    <span class="text-warning"><i
                                                                            class="fas fa-exclamation-circle"></i>
                                                                        Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        id="prasarana-air-tanah-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Peralatan Air Tanah</td>
                                                                <td>
                                                                    @if ($allPeralatanAirTanahFilled)
                                                                    <span class="text-success"><i
                                                                            class="fas fa-check-circle"></i>
                                                                        Selesai</span>
                                                                    @else
                                                                    <span class="text-warning"><i
                                                                            class="fas fa-exclamation-circle"></i>
                                                                        Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        id="peralatan-air-tanah-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            @elseif ($jaringan->jenis == 'Air Baku' || $jaringan->jenis
                                                            == 'Embung')
                                                            <tr>
                                                                <td>Prasarana Air Baku/Embung</td>
                                                                <td>
                                                                    @if($allPrasaranaAirBakuEmbungFilled)
                                                                    <span class="text-success"><i
                                                                            class="fas fa-check-circle"></i>
                                                                        Selesai</span>
                                                                    @else
                                                                    <span class="text-warning"><i
                                                                            class="fas fa-exclamation-circle"></i>
                                                                        Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        id="prasarana-air-baku-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td>Uji Pengaliran</td>
                                                                <td></td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        data-toggle="modal"
                                                                        data-target="#uji-pengaliran">
                                                                        <span class="fas fa-upload"
                                                                            title="Upload"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="v-tabs-profile" role="tabpanel"
                                                    aria-labelledby="v-tabs-profile-tab">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Data dan Informasi Non-Fisik</td>
                                                                <td></td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        id="data-dan-informasi-non-fisik-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="v-tabs-messages" role="tabpanel"
                                                    aria-labelledby="v-tabs-messages-tab">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Kesiapan Sarana Penunjang Operasi dan Pemeliharaan
                                                                </td>
                                                                <td></td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        id="kesiapan-sarana-penunjang-operasi-dan-pemeliharaan-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Kesiapan Kelembagaan dan Sumber Daya Manusia</td>
                                                                <td></td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        id="kesiapan-kelembagaan-dan-sumber-daya-manusia-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Kesiapan Manajemen</td>
                                                                <td></td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        id="kesiapan-manajemen-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Kesiapan Konservasi</td>
                                                                <td></td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        id="kesiapan-konservasi-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Penyusunan BA Hasil Evaluasi Awal Kesiapan OP</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Evaluasi Akhir Kesiapan OP</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Penyusunan BA Hasil Evaluasi Akhir Kesiapan OP</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Serah Terima Hasil OP</td>
                    <td></td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#serah-terima">
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Dokumen Tambahan</h3>
    </div>
    <div class="card-body">
        <table class="table table-sm table-bordered table-hover">
            <thead>
                <tr>
                    <th>Dokumen</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Kontrak</td>
                    <td></td>
                    <td>
                        <button class="btn btn-sm btn-primary" id="kontrak-button" data-toggle="modal"
                            data-target="#dokumen-kontrak">
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                </tr>
                <tr>
                    <td>As Build Drawing</td>
                    <td></td>
                    <td>
                        <button class="btn btn-sm btn-primary" id="as-build-drawing-button" data-toggle="modal"
                            data-target="#as-build-drawing">
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>PHO/FHO</td>
                    <td></td>
                    <td>
                        <button class="btn btn-sm btn-primary" id="pho-fho-button" data-toggle="modal"
                            data-target="#pho-fho">
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>Manual OP</td>
                    <td></td>
                    <td>
                        <button class="btn btn-sm btn-primary" id="manual-op-button" data-toggle="modal"
                            data-target="#manual-op">
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>Dokumentasi</td>
                    <td></td>
                    <td>
                        <button class="btn btn-sm btn-primary" id="dokumentasi-button" data-toggle="modal"
                            data-target="#dokumentasi">
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                    </td>
                </tr>
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
                <h5 class="modal-title" id="penyusunanRencanaKerjaShowModalLabel">Dokumen Penyusunan Rencana Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="d-flex justify-content-center">
                        @if ($dokumenPenyusunanRencanaKerja)
                        <a href="{{ asset('storage/' . substr($dokumenPenyusunanRencanaKerja->path_dokumen, 7)) }}"
                            target="_blank" class="btn btn-primary btn-sm">Lihat file Penyusunan Rencana Kerja</a>
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

<!-- Modla Uji Pengaliran -->
<div class="modal fade" id="uji-pengaliran" tabindex="-1" aria-labelledby="ujiPengaliranModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ujiPengaliranModalLabel">Dokumen Uji Pengaliran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <!-- Upload form uji pengaliran -->
                    <form id="formUjiPengaliran"
                        action="{{ route('inventarisasi-awal-prasarana-air-baku-uji-pengaliran', $jaringan->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="dokumen_uji_pengaliran">Dokumen Berita Acara Uji Pengaliran</label>
                            <input type="file" accept="application/pdf" class="form-control" id="dokumen_uji_pengaliran"
                                name="dokumen_uji_pengaliran">
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Penysunan BA Hasil Evaluasi Awal Kesiapan OP -->
<div class="modal fade" id="BA-evaluasi-awal" tabindex="-1" aria-labelledby="BAEvaluasiAwalModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="BAEvaluasiAwalModalLabel">Penyusunan BA Hasil Evaluasi Awal Kesiapan OP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <!-- Upload form BA evaluasi awal -->
                    <form id="formBAEvaluasiAwal" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="penyusunan_ba_hasil_evaluasi_awal">Penyusunan BA Hasil Evaluasi Awal Kesiapan
                                OP</label>
                            <input type="file" accept="application/pdf" class="form-control"
                                id="penyusunan_ba_hasil_evaluasi_awal" name="penyusunan_ba_hasil_evaluasi_awal">
                        </div>
                        <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal dokumen tambahan --}}
@include('dokumen-tambahan.modal-kontrak')
@include('dokumen-tambahan.as-build-draw')
@include('dokumen-tambahan.pho-fho')
@include('dokumen-tambahan.manual-op')
@include('dokumen-tambahan.dokumentasi')

<a href="{{ route('jaringan-atab.index') }}" class="btn btn-primary mb-3 btn-sm"><i class="fas fa-arrow-left"></i>
    kembali ke Daftar</a>
@stop

@section('css')
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

        //-----Halman FORM EVALUASI AWAL---------//
        var evaluasiAwalButton = document.getElementById('evaluasi-awal-button');
        if (evaluasiAwalButton) {
            evaluasiAwalButton.addEventListener('click', function() {
                var url = "{{ route('evaluasi-awal', ['jaringan' => $jaringan->id]) }}";
                window.open(url, '_blank', 'width=800,height=600,resizable=no');
            });
        }

        //-----Halaman FORM Prasarana Air Tanah---------//
        var prasaranaAirTanahButton = document.getElementById('prasarana-air-tanah-button');
        if (prasaranaAirTanahButton) {
            prasaranaAirTanahButton.addEventListener('click', function() {
                var url = "{{ route('inventarisasi-awal-prasarana-air-tanah', ['jaringan' => $jaringan->id]) }}";
                window.open(url, '_blank', 'width=900,height=600,resizable=no');
            });
        }

        //-----Halaman FORM Perlatan Air Tanah---------//
        var peralatanAirTanahButton = document.getElementById('peralatan-air-tanah-button');
        if (peralatanAirTanahButton) {
            peralatanAirTanahButton.addEventListener('click', function() {
                var url = "{{ route('inventarisasi-awal-peralatan-air-tanah', ['jaringan' => $jaringan->id]) }}";
                window.open(url, '_blank', 'width=900,height=600,resizable=no');
            });
        }

        //-----Halaman FORM Prasarana Air Baku---------//
        var prasaranaAirBakuButton = document.getElementById('prasarana-air-baku-button');
        if (prasaranaAirBakuButton) {
            prasaranaAirBakuButton.addEventListener('click', function() {
                var url = "{{ route('inventarisasi-awal-prasarana-air-baku', ['jaringan' => $jaringan->id]) }}";
                window.open(url, '_blank', 'width=900,height=600,resizable=no');
            });
        }

        //-----Halaman Form Data dan Informasi Non-Fisik---------//
        var dataInformasiNonFisikButton = document.getElementById('data-dan-informasi-non-fisik-button');
        if (dataInformasiNonFisikButton) {
            dataInformasiNonFisikButton.addEventListener('click', function() {
                var url = "{{ route('inventarisasi-awal-data-informasi-non-fisik', ['jaringan' => $jaringan->id]) }}";
                window.open(url, '_blank', 'width=900,height=600,resizable=no');
            });
        }

        //-----Halaman Kesiapan Sarana Penunjang Operasi dan Pemeliharaan---------//
        var kesiapanSaranaPenunjangOperasiDanPemeliharaanButton = document.getElementById('kesiapan-sarana-penunjang-operasi-dan-pemeliharaan-button');
        if (kesiapanSaranaPenunjangOperasiDanPemeliharaanButton) {
            kesiapanSaranaPenunjangOperasiDanPemeliharaanButton.addEventListener('click', function() {
                var url = "{{ route('inventarisasi-awal-kesiapan-sarana-penunjang-op', ['jaringan' => $jaringan->id]) }}";
                window.open(url, '_blank', 'width=950,height=600,resizable=no');
            });
        }

        //-----Halaman Kesiapan Kelembagaan dan Sumber Daya Manusia---------//
        var kesiapanKelembagaanDanSumberDayaManusiaButton = document.getElementById('kesiapan-kelembagaan-dan-sumber-daya-manusia-button');
        if (kesiapanKelembagaanDanSumberDayaManusiaButton) {
            kesiapanKelembagaanDanSumberDayaManusiaButton.addEventListener('click', function() {
                var url = "{{ route('inventarisasi-awal-kesiapan-kelembagaan-sdm', ['jaringan' => $jaringan->id]) }}";
                window.open(url, '_blank', 'width=950,height=600,resizable=no');
            });
        }

        //-----Halaman Kesiapan Manajemen---------//
        var kesiapanManajemenButton = document.getElementById('kesiapan-manajemen-button');
        if (kesiapanManajemenButton) {
            kesiapanManajemenButton.addEventListener('click', function() {
                var url = "{{ route('inventarisasi-awal-kesiapan-manajemen', ['jaringan' => $jaringan->id]) }}";
                window.open(url, '_blank', 'width=1100,height=600,resizable=no');
            });
        }

        //-----Halaman Keisapan Konservasi---------//
        var kesiapanKonservasiButton = document.getElementById('kesiapan-konservasi-button');
        if (kesiapanKonservasiButton) {
            kesiapanKonservasiButton.addEventListener('click', function() {
                var url = "{{ route('inventarisasi-awal-kesiapan-konservasi', ['jaringan' => $jaringan->id]) }}";
                window.open(url, '_blank', 'width=1100,height=600,resizable=no');
            });
        }

        // Toggle icon direction on collapse show/hide
        $('.collapse').on('show.bs.collapse', function () {
            $(this).prev().find('.fas').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        }).on('hide.bs.collapse', function () {
            $(this).prev().find('.fas').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        });
    });
</script>
@stop