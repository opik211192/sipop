@extends('adminlte::page')

@section('title', 'Detail Jaringan')

@section('content_header')
{{-- <h1>Detail</h1> --}}
<div></div>
@stop

@section('content')
<div class="card card-outline shadow-sm">
    <div class="card-header bg-gradient-primary text-white">
        <h3 class="card-title d-flex align-items-center">
            <i class="fas fa-info-circle mr-2 border-bottom" data-toggle="tooltip" data-placement="top"
                title="Informasi Data"></i>
            Informasi Data
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
                <table class="table table-sm table-bordered table-hover table-striped">
                    <tbody>
                        <tr>
                            <th class="text-muted"><i class="fas fa-network-wired mr-2"></i> Nama</th>
                            <td class="font-weight-bold text-dark">{{ $jaringan->nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="fas fa-map-marker-alt mr-2"></i> Koordinat</th>
                            <td class="font-weight-bold text-dark">{{ $jaringan->latitude }}, {{
                                $jaringan->longitude }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="fas fa-map-marked-alt mr-2"></i> Provinsi</th>
                            <td class="font-weight-bold text-dark">{{ $jaringan->province ?
                                ucwords(strtolower($jaringan->province->name)) :
                                'Tidak
                                tersedia' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="fas fa-city mr-2"></i> Kota/Kabupaten</th>
                            <td class="font-weight-bold text-dark">{{ $jaringan->city ?
                                ucwords(strtolower($jaringan->city->name)) :
                                'Tidak
                                tersedia' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="fas fa-building mr-2"></i> Kecamatan</th>
                            <td class="font-weight-bold text-dark">{{ $jaringan->district ?
                                ucwords(strtolower($jaringan->district->name)) :
                                'Tidak
                                tersedia' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="fas fa-home mr-2"></i> Desa</th>
                            <td class="font-weight-bold text-dark">{{ $jaringan->village ?
                                ucwords(strtolower($jaringan->village->name))
                                : 'Tidak
                                tersedia'
                                }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-6">
                <table class="table table-sm table-bordered table-hover table-striped">
                    <tbody>
                        <tr>
                            <th class="text-muted"><i class="fas fa-water mr-2"></i>DAS</th>
                            <td class="font-weight-bold text-dark">{{ $jaringan->wilayah_sungai }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="fas fa-cog mr-2"></i>Infrastruktur</th>
                            <td class="font-weight-bold text-dark">{{ $jaringan->jenis }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="fas fa-calendar-alt mr-2"></i>Tahun</th>
                            <td class="font-weight-bold text-dark">{{ $jaringan->tahun }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="fas fa-building mr-2"></i>Satker</th>
                            <td class="font-weight-bold text-dark">{{ $jaringan->satker }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="fas fa-tasks mr-2"></i>Tahapan</th>
                            <td>
                                @if($jaringan->tahapan)
                                @if($jaringan->tahapan == 'Serah Terima Hasil OP')
                                <span class="badge badge-success">{{ $jaringan->tahapan }}</span>
                                @else
                                <span class="badge badge-info">{{ $jaringan->tahapan }}</span>
                                @endif
                                @else
                                <span class="badge badge-danger badge-pill">Belum Tahapan</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card card-outline card-primary sahdow-sm">
    <div class="card-header bg-gradient-primary text-white">
        <h3 class="card-title d-flex align-items-center">
            <i class="fas fa-wrench text mr-2"></i>
            Persiapan Operasi Pemeliharaan
        </h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-sm">
            <thead class="bg-gradient-primary text-white">
                <tr>
                    <th class="text-center border-bottom border-light">Nama Tahapan <i class="fas fa-tasks ml-2"></i>
                    </th>
                    <th class="text-center border-bottom border-light">Status <i class="fas fa-info-circle ml-2"></i>
                    </th>
                    <th class="text-center border-bottom border-light">Action <i class="fas fa-cog ml-2"></i></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="bg-white">
                        <i class="fas fa-users fa-lg text-success mr-2"></i>
                        <span class="font-weight-bold text-dark">Pembentukan Tim</span>
                    </td>
                    <td>
                        @php
                        $tahapanPembentukanTim = $jaringan->tahapans->where('nama_tahapan', 'Pembentukan Tim')->first();
                        $dokumenPembina = $tahapanPembentukanTim ?
                        $tahapanPembentukanTim->dokumens->where('nama_dokumen', 'SK Tim Pembina')->first() : null;
                        $dokumenPelaksana = $tahapanPembentukanTim ?
                        $tahapanPembentukanTim->dokumens->where('nama_dokumen', 'SK Tim Pelaksana')->first() : null;
                        @endphp

                        @if($dokumenPembina && $dokumenPelaksana)
                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Selesai</span>
                        @else
                        <span class="badge badge-warning"><i class="fas fa-exclamation-circle"></i> Pending</span>
                        @endif
                    </td>
                    <td>
                        @if ($dokumenPembina && $dokumenPelaksana)
                        <button type="button" class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                            data-target="#pembentukan-tim-show">
                            <span class="fas fa-eye" title="Lihat Dokumen"></span></button>
                        <button type="button" class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                            data-target="#pembentukan-tim-edit">
                            <span class="fas fa-edit" title="Edit"></span>
                        </button>
                        @else
                        <button type="button" class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                            data-target="#pembentukan-tim">
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="bg-white">
                        <i class="fas fa-calendar-alt fa-lg text-info mr-2"></i>
                        <span class="font-weight-bold text-dark">Penyusunan Rencana Kerja</span>
                    </td>
                    <td>
                        @php
                        $rencanakerja = $jaringan->tahapans->where('nama_tahapan', 'Penyusunan Rencana Kerja')->first();
                        $dokumenPenyusunanRencanaKerja = $rencanakerja ? $rencanakerja->dokumens->where('nama_dokumen',
                        'Penyusunan Rencana Kerja')->first() : null;
                        @endphp
                        @if($dokumenPenyusunanRencanaKerja)
                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Selesai</span>
                        @else
                        <span class="badge badge-warning"><i class="fas fa-exclamation-circle"></i> Pending</span>
                        @endif
                    </td>
                    <td>
                        @if ($dokumenPenyusunanRencanaKerja)
                        <button type="button" class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                            data-target="#penyusunan-rencana-kerja-show">
                            <span class="fas fa-eye" title="Lihat Dokumen"></span>
                        </button>
                        <button type="button" class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                            data-target="#penyusunan-rencana-kerja-edit">
                            <span class="fas fa-edit" title="Edit"></span>
                        </button>
                        @elseif ($dokumenPembina && $dokumenPelaksana)
                        <button type="button" class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                            data-target="#penyusunan-rencana-kerja">
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                        @else
                        <button type="button" class="btn bg-gradient-primary btn-sm" disabled>
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="bg-white">
                        <i class="fas fa-handshake fa-lg text-success mr-2"></i>
                        <span class="font-weight-bold text-dark">Sosialisasi dan Koordinasi</span>
                    </td>
                    <td>
                        <?php
                        $sosialisasi = $jaringan->tahapans->where('nama_tahapan', 'Sosialisasi dan Koordinasi')->first();
                        
                        $dokumenSosialisasi = $sosialisasi ? 
                        $sosialisasi->dokumens->where('nama_dokumen', 'Sosialisasi dan Koordinasi')->first() : null;
                        ?>

                        @if($dokumenSosialisasi)
                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Selesai</span>
                        @else
                        <span class="badge badge-warning"><i class="fas fa-exclamation-circle"></i> Pending</span>
                        @endif
                    </td>
                    <td>
                        @if ($dokumenSosialisasi)
                        <button type="button" class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                            data-target="#sosialisasi-dan-koordinasi-show">
                            <span class="fas fa-eye" title="Lihat Dokumen"></span>
                        </button>
                        <button type="button" class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                            data-target="#sosialisasi-dan-koordinasi-edit">
                            <span class="fas fa-edit" title="Edit"></span>
                        </button>
                        @elseif ($dokumenPenyusunanRencanaKerja)
                        <button type="button" class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                            data-target="#sosialisai-dan-koordiansi">
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                        @else
                        <button type="button" class="btn bg-gradient-primary btn-sm" disabled>
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <i class="fas fa-tasks fa-lg text-primary mr-2"></i>
                        <span class="font-weight-bold text-dark">Penyusunan Evaluasi Awal Kesiapan</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <a data-toggle="collapse" href="#collapseInventarisasi" role="button" aria-expanded="false"
                            aria-controls="collapseInventarisasi"
                            class="d-flex align-items-center text-decoration-none">
                            <div class="p-1 bg-gradient-primary text-white rounded-circle mr-2">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <span class="font-weight-bold text-dark">Inventarisasi Data dan Informasi dan Evaluasi
                                Awal Kesiapan OP</span>
                            <i class="fas fa-chevron-down ml-auto text-primary"></i>
                        </a>
                        <div class="collapse " id="collapseInventarisasi">
                            <div class="card card-body">
                                <div class="container mt-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="nav flex-column nav-tabs" id="v-tabs" role="tablist"
                                                aria-orientation="vertical">
                                                <a class="nav-link bg-light text-white mb-2 d-flex align-items-center"
                                                    id="v-tabs-home-tab" data-toggle="pill" href="#v-tabs-home"
                                                    role="tab" aria-controls="v-tabs-home" aria-selected="true">
                                                    <i class="fas fa-hammer mr-2"></i> Data dan Informasi Pekerjaan
                                                    Fisik
                                                </a>
                                                <a class="nav-link bg-light text-dark mb-2 d-flex align-items-center"
                                                    id="v-tabs-profile-tab" data-toggle="pill" href="#v-tabs-profile"
                                                    role="tab" aria-controls="v-tabs-profile" aria-selected="false">
                                                    <i class="fas fa-file-alt mr-2"></i> Data dan Informasi Non-Fisik
                                                </a>
                                                <a class="nav-link bg-light text-dark d-flex align-items-center"
                                                    id="v-tabs-messages-tab" data-toggle="pill" href="#v-tabs-messages"
                                                    role="tab" aria-controls="v-tabs-messages" aria-selected="false">
                                                    <i class="fas fa-cogs mr-2"></i> Sarana dan Prasarana Pendukung
                                                </a>
                                                <a class="nav-link bg-light text-dark d-flex align-items-center" id="v-tabs-hasil-evaluasi-tab" data-toggle="pill"
                                                    href="#v-tabs-hasil-evaluasi" role="tab" aria-controls="v-tabs-hasil-evaluasi" aria-selected="false">
                                                    <i class="fas fa-check-circle mr-2"></i> Hasil Evaluasi Awal Kesiapan OP
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="tab-content" id="v-tabs-tabContent">
                                                <div class="tab-pane fade show active" id="v-tabs-home" role="tabpanel"
                                                    aria-labelledby="v-tabs-home-tab">
                                                    <table class="table table-sm">
                                                        <thead class="bg-gradient-primary text-white">
                                                            <tr>
                                                                <th class="text-center border-bottom border-light">
                                                                    <i class="fas fa-hammer mr-2"></i> Data dan
                                                                    Informasi Pekerjaan Fisik
                                                                </th>
                                                                <th class="text-center border-bottom border-light">
                                                                    Status <i class="fas fa-info-circle ml-2"></i>
                                                                </th>
                                                                <th class="text-center border-bottom border-light">
                                                                    Action <i class="fas fa-cog ml-2"></i></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $evaluasiAwal = $jaringan->tahapans->where('nama_tahapan',
                                                            'Evaluasi Awal Kesiapan')->first();

                                                            // Evaluasi Blanko 1A
                                                            $evaluasiBlanko1A = $evaluasiAwal ?
                                                            $evaluasiAwal->evaluasiBlankos->where('jenis_blanko',
                                                            'Blanko 1A')->first() : null;
                                                            $isBlanko1APartiallyFilled = $evaluasiBlanko1A &&
                                                            $evaluasiBlanko1A->items->some(function ($item) {
                                                            return $item->ada_tidak_ada == 1;
                                                            });

                                                            // Evaluasi Blanko 1B
                                                            $evaluasiBlanko1B = $evaluasiAwal ?
                                                            $evaluasiAwal->evaluasiBlankos->where('jenis_blanko',
                                                            'Blanko 1B')->first() : null;
                                                            $isBlanko1BPartiallyFilled = $evaluasiBlanko1B &&
                                                            $evaluasiBlanko1B->items->some(function ($item) {
                                                            return $item->ada_tidak_ada == 1;
                                                            });

                                                            // Evaluasi Blanko 1C
                                                            $evaluasiBlanko1C = $evaluasiAwal ?
                                                            $evaluasiAwal->evaluasiBlankos->where('jenis_blanko',
                                                            'Blanko 1C')->first() : null;
                                                            $isBlanko1CPartiallyFilled = $evaluasiBlanko1C &&
                                                            $evaluasiBlanko1C->items->some(function ($item) {
                                                            return $item->ada_tidak_ada == 1;
                                                            });

                                                            $ujiPengaliran = $jaringan->tahapans->where('nama_tahapan','Evaluasi Awal Kesiapan')->first();


                                                            $dokumenUjiPengaliran = $ujiPengaliran ?
                                                            $ujiPengaliran->dokumens->where('nama_dokumen', 'Dokumen Uji Pengaliran')->first() :
                                                            null;

                                                        
                                                            ?>

                                                            @if ($jaringan->jenis == 'Air Tanah')
                                                            <tr>
                                                                <td>Prasarana Air Tanah <strong>(Blanko 1A)</strong>
                                                                </td>
                                                                <td>
                                                                    @if($isBlanko1APartiallyFilled)
                                                                    <span class="badge badge-info"><i
                                                                            class="fas fa-info-circle"></i>
                                                                        Terisi</span>
                                                                    @else
                                                                    <span class="badge badge-warning"><i
                                                                            class="fas fa-exclamation-circle"></i>
                                                                        Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-sm bg-gradient-primary"
                                                                        id="prasarana-air-tanah-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Peralatan Air Tanah <strong>(Blanko 1B)</strong>
                                                                </td>
                                                                <td>
                                                                    @if($isBlanko1BPartiallyFilled)
                                                                    <span class="badge badge-info"><i
                                                                            class="fas fa-info-circle"></i>
                                                                        Terisi</span>
                                                                    @else
                                                                    <span class="badge badge-warning"><i
                                                                            class="fas fa-exclamation-circle"></i>
                                                                        Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-sm bg-gradient-primary"
                                                                        id="peralatan-air-tanah-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            @elseif ($jaringan->jenis == 'Air Baku' || $jaringan->jenis
                                                            == 'Embung')
                                                            <tr>
                                                                <td>Prasarana Air Baku/Embung <strong>(Blanko
                                                                        1C)</strong></td>
                                                                <td>
                                                                    @if($isBlanko1CPartiallyFilled)
                                                                    <span class="badge badge-info"><i
                                                                            class="fas fa-info-circle"></i>
                                                                        Terisi</span>
                                                                    @else
                                                                    <span class="badge badge-warning"><i
                                                                            class="fas fa-exclamation-circle"></i>
                                                                        Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-sm bg-gradient-primary"
                                                                        id="prasarana-air-baku-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td>Uji Pengaliran</td>
                                                                <td>
                                                                    @if($dokumenUjiPengaliran)
                                                                    <span class="badge badge-success"><i
                                                                            class="fas fa-check-circle"></i>
                                                                        Selesai</span>
                                                                    @else
                                                                    <span class="badge badge-warning"><i
                                                                            class="fas fa-exclamation-circle"></i>
                                                                        Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($dokumenUjiPengaliran)
                                                                    <button type="button"
                                                                        class="btn bg-gradient-primary btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#uji-pengaliran-show">
                                                                        <span class="fas fa-eye"
                                                                            title="Lihat Dokumen"></span>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn bg-gradient-primary btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#uji-pengaliran-edit">
                                                                        <span class="fas fa-edit" title="Edit"></span>
                                                                    </button>
                                                                    @else
                                                                    <button type="button"
                                                                        class="btn bg-gradient-primary btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#uji-pengaliran">
                                                                        <span class="fas fa-upload"
                                                                            title="Upload Dokumen"></span>
                                                                    </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="v-tabs-profile" role="tabpanel"
                                                    aria-labelledby="v-tabs-profile-tab">
                                                    <table class="table table-sm">
                                                        <thead class="bg-gradient-primary text-white">
                                                            <tr>
                                                                <th class="text-center border-bottom border-light">
                                                                    <i class="fas fa-file-alt mr-2"></i> Data dan
                                                                    Informasi
                                                                    Non-Fisik
                                                                </th>
                                                                <th class="text-center border-bottom border-light">
                                                                    Status <i class="fas fa-info-circle ml-2"></i>
                                                                </th>
                                                                <th class="text-center border-bottom border-light">
                                                                    Action <i class="fas fa-cog ml-2"></i></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            // Evaluasi Blanko 2 (Data dan Informasi Non-Fisik)
                                                            $evaluasiBlanko2 = $evaluasiAwal ?
                                                            $evaluasiAwal->evaluasiBlankos->where('jenis_blanko',
                                                            'Blanko 2')->first() : null;
                                                            $isBlanko2PartiallyFilled = $evaluasiBlanko2 &&
                                                            $evaluasiBlanko2->items->some(function ($item) {
                                                            return $item->ada_tidak_ada == 1;
                                                            });
                                                            @endphp
                                                            <tr>
                                                                <td>Data dan Informasi Non-Fisik <strong>(Blanko
                                                                        2)</strong></td>
                                                                <td>
                                                                    @if($isBlanko2PartiallyFilled)
                                                                    <span class="badge badge-info"><i
                                                                            class="fas fa-info-circle"></i>
                                                                        Terisi</span>
                                                                    @else
                                                                    <span class="badge badge-warning"><i
                                                                            class="fas fa-exclamation-circle"></i>
                                                                        Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-sm bg-gradient-primary"
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
                                                        <thead class="bg-gradient-primary text-white">
                                                            <tr>
                                                                <th class="text-center border-bottom border-light">
                                                                    <i class="fas fa-cogs mr-2"></i> Sarana dan
                                                                    Prasarana Pendukung
                                                                </th>
                                                                <th class="text-center border-bottom border-light">
                                                                    Status <i class="fas fa-info-circle ml-2"></i>
                                                                </th>
                                                                <th class="text-center border-bottom border-light">
                                                                    Action <i class="fas fa-cog ml-2"></i></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                            $evaluasiAwal = $jaringan->tahapans->where('nama_tahapan',
                                                            'Evaluasi Awal Kesiapan')->first();

                                                            // Evaluasi Blanko 3A
                                                            $evaluasiBlanko3A = $evaluasiAwal ?
                                                            $evaluasiAwal->evaluasiBlankos->where('jenis_blanko',
                                                            'Blanko 3A')->first() :
                                                            null;
                                                            $isBlanko3APartiallyFilled = $evaluasiBlanko3A &&
                                                            $evaluasiBlanko3A->itemBlanko3->some(function ($item) {
                                                            return $item->rincians->some(function ($rinci) {
                                                            return $rinci->ada_tidak_ada == 1;
                                                            });
                                                            });

                                                            // Evaluasi Blanko 3B
                                                            $evaluasiBlanko3B = $evaluasiAwal ?
                                                            $evaluasiAwal->evaluasiBlankos->where('jenis_blanko',
                                                            'Blanko 3B')->first() :
                                                            null;
                                                            $isBlanko3BPartiallyFilled = $evaluasiBlanko3B &&
                                                            $evaluasiBlanko3B->itemBlanko3->some(function ($item) {
                                                            return $item->rincians->some(function ($rinci) {
                                                            return $rinci->ada_tidak_ada == 1;
                                                            });
                                                            });

                                                            // Evaluasi Blanko 3C
                                                            $evaluasiBlanko3C = $evaluasiAwal ?
                                                            $evaluasiAwal->evaluasiBlankos->where('jenis_blanko',
                                                            'Blanko 3C')->first() :
                                                            null;
                                                            $isBlanko3CPartiallyFilled = $evaluasiBlanko3C &&
                                                            $evaluasiBlanko3C->itemBlanko3->some(function ($item) {
                                                            return $item->rincians->some(function ($rinci) {
                                                            return $rinci->ada_tidak_ada == 1;
                                                            });
                                                            });

                                                            // Evaluasi Blanko 3D
                                                            $evaluasiBlanko3D = $evaluasiAwal ?
                                                            $evaluasiAwal->evaluasiBlankos->where('jenis_blanko',
                                                            'Blanko 3D')->first() :
                                                            null;
                                                            $isBlanko3DPartiallyFilled = $evaluasiBlanko3D &&
                                                            $evaluasiBlanko3D->itemBlanko3->some(function ($item) {
                                                            return $item->rincians->some(function ($rinci) {
                                                            return $rinci->ada_tidak_ada == 1;
                                                            });
                                                            });
                                                            @endphp

                                                            <tr>
                                                                <td>Kesiapan Sarana Penunjang Operasi dan Pemeliharaan
                                                                    <strong>(Blanko 3A)</strong>
                                                                </td>
                                                                <td>
                                                                    @if($isBlanko3APartiallyFilled)
                                                                    <span class="badge badge-info"><i
                                                                            class="fas fa-info-circle"></i>
                                                                        Terisi</span>
                                                                    @else
                                                                    <span class="badge badge-warning"><i
                                                                            class="fas fa-exclamation-circle"></i>
                                                                        Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        id="kesiapan-sarana-penunjang-operasi-dan-pemeliharaan-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Kesiapan Kelembagaan dan Sumber Daya Manusia
                                                                    <strong>(Blanko
                                                                        3B)</strong>
                                                                </td>
                                                                <td>
                                                                    @if($isBlanko3BPartiallyFilled)
                                                                    <span class="badge badge-info"><i
                                                                            class="fas fa-info-circle"></i>
                                                                        Terisi</span>
                                                                    @else
                                                                    <span class="badge badge-warning"><i
                                                                            class="fas fa-exclamation-circle"></i>
                                                                        Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        id="kesiapan-kelembagaan-dan-sumber-daya-manusia-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Kesiapan Manajemen <strong>(Blanko 3C)</strong></td>
                                                                <td>
                                                                    @if($isBlanko3CPartiallyFilled)
                                                                    <span class="badge badge-info"><i
                                                                            class="fas fa-info-circle"></i>
                                                                        Terisi</span>
                                                                    @else
                                                                    <span class="badge badge-warning"><i
                                                                            class="fas fa-exclamation-circle"></i>
                                                                        Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-primary"
                                                                        id="kesiapan-manajemen-button">
                                                                        <span class="fas fa-newspaper"
                                                                            title="Proses"></span>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Kesiapan Konservasi <strong>(Blanko 3D)</strong>
                                                                </td>
                                                                <td>
                                                                    @if($isBlanko3DPartiallyFilled)
                                                                    <span class="badge badge-info"><i
                                                                            class="fas fa-info-circle"></i>
                                                                        Terisi</span>
                                                                    @else
                                                                    <span class="badge badge-warning"><i
                                                                            class="fas fa-exclamation-circle"></i>
                                                                        Pending</span>
                                                                    @endif
                                                                </td>
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
                                                <div class="tab-pane fade" id="v-tabs-hasil-evaluasi" role="tabpanel" aria-labelledby="v-tabs-hasil-evaluasi-tab">
                                                    <table class="table table-sm">
                                                        <thead class="bg-gradient-primary text-white">
                                                            <tr>
                                                                <th class="text-center border-bottom border-light">
                                                                    <i class="fas fa-check-circle mr-2"></i> Hasil Evaluasi Awal Kesiapan OP
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex justify-content-center">
                                                                        <!-- Tombol untuk melihat modal BA Evaluasi Awal -->
                                                                            <button class="btn btn-sm bg-gradient-success" data-toggle="modal" data-target="#modal-ba-evaluasi-{{ $jaringan->id }}">
                                                                                <span class="fas fa-file-signature" title="Lihat Penyusunan BA Hasil Evaluasi Awal Kesiapan OP"></span> Lihat Hasil Evalusai Kesiapan OP
                                                                            </button>
                                                                    </div>
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
                @php
                    // Ambil status apakah semua Blanko sudah terisi
                    $allBlankoCompleted = ($isBlanko1APartiallyFilled || $isBlanko1BPartiallyFilled ||
                    $isBlanko1CPartiallyFilled || $isBlanko2PartiallyFilled ||
                    $isBlanko3APartiallyFilled || $isBlanko3BPartiallyFilled ||
                    $isBlanko3CPartiallyFilled || $isBlanko3DPartiallyFilled);
                @endphp
                
                <tr>
                    <td class="bg-white">
                        <i class="fas fa-file-signature fa-lg text-primary mr-2"></i>
                        <span class="font-weight-bold text-dark">Penyusunan BA Hasil Evaluasi Awal Kesiapan OP</span>
                    </td>
                
                    <td class="bg-white">
                        @php
                        // Ambil tahapan yang sesuai dengan nama_tahapan 'BA Hasil Evaluasi Awal Kesiapan OP'
                        $tahapanBAEvaluasi = $jaringan->tahapans->where('nama_tahapan', 'BA Hasil Evaluasi Awal Kesiapan OP')->first();
                
                        // Cek apakah dokumen terkait dengan nama 'BA Evaluasi Awal Kesiapan OP' sudah ada
                        $dokumenEvaluasiAwal = $tahapanBAEvaluasi ?
                        $tahapanBAEvaluasi->dokumens->where('nama_dokumen', 'BA Evaluasi Awal Kesiapan OP')->first()
                        : null;
                        @endphp
                
                        @if($dokumenEvaluasiAwal)
                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Selesai</span>
                        @else
                        <span class="badge badge-warning"><i class="fas fa-exclamation-circle"></i> Pending</span>
                        @endif
                    </td>
                
                    <td class="bg-white">
                        @if($dokumenEvaluasiAwal)
                        {{-- Tombol untuk membuka modal show --}}
                        <button class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#show-ba-evaluasi-awal">
                            <span class="fas fa-eye" title="Lihat Dokumen Penyusunan BA Hasil Evaluasi Awal Kesiapan OP"></span>
                        </button>
                        <!-- Tombol untuk membuka modal edit BA Evaluasi Awal -->
                        <button class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#edit-ba-evaluasi-awal">
                            <span class="fas fa-edit" title="Edit Penyusunan BA Hasil Evaluasi Awal Kesiapan OP"></span>
                        </button>
                        @else
                        <!-- Tombol untuk membuka modal upload BA Evaluasi Awal -->
                        <button class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#upload-ba-evaluasi-awal"
                            @if(!$allBlankoCompleted) disabled @endif>
                            <span class="fas fa-upload" title="Upload Penyusunan BA Hasil Evaluasi Awal Kesiapan OP"></span>
                        </button>
                        @endif
                    </td>
                </tr>
                @php
                     // Ambil tahapan untuk BA Hasil Evaluasi Awal Kesiapan OP
                     $tahapanBAEvaluasiAwal = $jaringan->tahapans->where('nama_tahapan', 'BA Hasil Evaluasi Awal Kesiapan OP')->first();
                    
                     // Cek apakah dokumen BA Hasil Evaluasi Awal Kesiapan OP sudah ada
                     $dokumenBAEvaluasiAwal = $tahapanBAEvaluasiAwal ?
                     $tahapanBAEvaluasiAwal->dokumens->where('nama_dokumen', 'BA Evaluasi Awal Kesiapan OP')->first() : null;
                @endphp
                <tr>
                    <td class="bg-white">
                        <i class="fas fa-clipboard-check fa-lg text-primary mr-2"></i>
                        <span class="font-weight-bold text-dark">Evaluasi Akhir Kesiapan OP</span>
                    </td>
                    <td class="bg-white">
                        <?php
                        //cari tahaapan evaluasi akhir kesiapan OP
                        $tahapanEvaluasiAkhir = $jaringan->tahapans->where('nama_tahapan', 'Evaluasi Akhir Kesiapan')->first();

                        //cek apakah dokumen Evaluasi Akhir Kesiapan sudah ada
                        $dokumenEvaluasiAkhir = $tahapanEvaluasiAkhir ?
                        $tahapanEvaluasiAkhir->dokumens->where('nama_dokumen', 'Evaluasi Akhir Kesiapan')->first() : null;
                        ?>

                        @if($dokumenEvaluasiAkhir)
                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Selesai</span>
                        @else
                        <span class="badge badge-warning"><i class="fas fa-exclamation-circle"></i> Pending</span>
                        @endif  

                    </td>
                    <td class="bg-white">
                        @if($dokumenEvaluasiAkhir)
                        {{-- Tombol untuk membuka modal show --}}
                        <button class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#show-evaluasi-akhir">
                            <span class="fas fa-eye" title="Lihat Dokumen Evaluasi Akhir Kesiapan"></span>
                        </button>
                        <!-- Tombol untuk membuka modal edit Evaluasi Akhir -->
                        <button class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#edit-evaluasi-akhir">
                            <span class="fas fa-edit" title="Edit Evaluasi Akhir Kesiapan"></span>
                        </button>
                        @else
                        <!-- Tombol untuk membuka modal upload Evaluasi Akhir -->
                        <button class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#upload-evaluasi-akhir"
                            @if(!$dokumenBAEvaluasiAwal) disabled @endif>
                            <span class="fas fa-upload" title="Upload Evaluasi Akhir Kesiapan"></span>
                        </button>
                        @endif  
                    </td>
                </tr>
                <tr>
                    <td class="bg-white">
                        <i class="fas fa-file-alt fa-lg text-primary mr-2"></i>
                        <span class="font-weight-bold text-dark">Penyusunan BA Hasil Evaluasi Akhir Kesiapan OP</span>
                    </td>
                    <td class="bg-white">
                        <?php
                        //cari tahaapan evaluasi akhir kesiapan OP
                        $tahapanBAEvaluasiAkhir = $jaringan->tahapans->where('nama_tahapan', 'BA Hasil Evaluasi Akhir Kesiapan OP')->first();

                        //cek apakah dokumen Evaluasi Akhir Kesiapan sudah ada
                        $dokumenBAEvaluasiAkhir = $tahapanBAEvaluasiAkhir ?
                        $tahapanBAEvaluasiAkhir->dokumens->where('nama_dokumen', 'BA Hasil Evaluasi Akhir Kesiapan OP')->first() : null;
                        ?>

                        @if($dokumenBAEvaluasiAkhir)
                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Selesai</span>
                        @else
                        <span class="badge badge-warning"><i class="fas fa-exclamation-circle"></i> Pending</span>
                        @endif
                    </td>
                    <td class="bg-white">
                        @if ($dokumenBAEvaluasiAkhir)
                        {{-- Tombol untuk membuka modal show --}}
                        <button class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#show-ba-evaluasi-akhir">
                            <span class="fas fa-eye" title="Lihat Penyusunan BA Hasil Evaluasi Akhir Kesiapan OP"></span>
                        </button>
                        <!-- Tombol untuk membuka modal edit BA Evaluasi Akhir -->
                        <button class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#edit-ba-evaluasi-akhir">
                            <span class="fas fa-edit" title="Edit Penyusunan BA Hasil Evaluasi Akhir Kesiapan OP"></span>
                        </button>
                        @else
                        <!-- Tombol untuk membuka modal upload BA Evaluasi Akhir -->
                        <button class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#upload-ba-evaluasi-akhir"
                            @if(!$dokumenEvaluasiAkhir) disabled @endif>
                            <span class="fas fa-upload" title="Upload Penyusunan BA Hasil Evaluasi Akhir Kesiapan OP"></span>
                        </button>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="bg-white">
                        <i class="fas fa-handshake fa-lg text-success mr-2"></i>
                        <span class="font-weight-bold text-dark">Serah Terima Hasil OP</span>
                    </td>
                    <td class="bg-white">
                        <?php
                        
                        $tahapanSerahTerima = $jaringan->tahapans->where('nama_tahapan', 'Serah Terima hasil OP')->first();

                        $dokumenSerahTerima = $tahapanSerahTerima ?
                        $tahapanSerahTerima->dokumens->where('nama_dokumen', 'Serah Terima hasil OP')->first() : null;
                        ?>

                        @if($dokumenSerahTerima)
                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Selesai</span>
                        @else
                        <span class="badge badge-warning"><i class="fas fa-exclamation-circle"></i> Pending</span>
                        @endif

                    </td>
                    <td class="bg-white">
                        @if ($dokumenSerahTerima)
                        {{-- Tombol untuk membuka modal show --}}
                        <button class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#show-serah-terima-op">
                            <span class="fas fa-eye" title="Lihat Serah Terima Hasil OP"></span>
                        </button>
                        <!-- Tombol untuk membuka modal edit Serah Terima -->
                        <button class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#edit-serah-terima-op">
                            <span class="fas fa-edit" title="Edit Serah Terima Hasil OP"></span>
                        </button>
                        @else
                        <!-- Tombol untuk membuka modal upload Serah Terima -->
                        <button class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#upload-serah-terima-op"
                            @if(!$dokumenBAEvaluasiAkhir) disabled @endif>
                            <span class="fas fa-upload" title="Upload Serah Terima Hasil OP"></span>
                        </button>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card card-outline shadow-sm">
    <div class="card-header bg-gradient-primary text-white">
        <h3 class="card-title d-flex align-items-center">
            <i class="fas fa-file-contract mr-2"></i>
            Lihat Hasil Dokumen
        </h3>
    </div>
    <div class="card-body bg-light">
        <table class="table table-sm table-hover table-bordered">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="text-center">Dokumen</th>

                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
             <tr>
               @php
                    $dokumenKontrak = null;
                    $dokumenAsBuildDrawing = null;
                    $dokumenPHO = null;
                    $dokumenManualOP = null;
                    $dokumenDokumentasi = null;

                    // Cari tahapan yang sesuai
                    $tahapanEvaluasiAwal = $jaringan->tahapans->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

                    if ($tahapanEvaluasiAwal) {
                        // Cari evaluasi blanko2 yang sesuai
                        $evaluasiBlanko2 = $tahapanEvaluasiAwal->evaluasiBlankos->where('jenis_blanko', 'Blanko 2')->first();

                        if ($evaluasiBlanko2) {
                            // Kontrak
                            $itemKontrak = \DB::table('item_blankos')
                                ->where('evaluasi_blanko_id', $evaluasiBlanko2->id)
                                ->where('nama_item', 'Kontrak')
                                ->first();

                            if ($itemKontrak) {
                                $dokumenKontrak = \DB::table('blanko2_uploads')
                                    ->where('item_blanko_id', $itemKontrak->id)
                                    ->select('id', 'nama_file')
                                    ->first();
                            }

                            // As Build Drawing
                            $itemAsBuildDrawing = \DB::table('item_blankos')
                                ->where('evaluasi_blanko_id', $evaluasiBlanko2->id)
                                ->where('nama_item', 'As Build Drawing')
                                ->first();

                            if ($itemAsBuildDrawing) {
                                $dokumenAsBuildDrawing = \DB::table('blanko2_uploads')
                                    ->where('item_blanko_id', $itemAsBuildDrawing->id)
                                    ->select('id', 'nama_file')
                                    ->first();
                            }

                            // PHO
                            $itemPHO = \DB::table('item_blankos')
                                ->where('evaluasi_blanko_id', $evaluasiBlanko2->id)
                                ->where('nama_item', 'PHO')
                                ->first();

                            if ($itemPHO) {
                                $dokumenPHO = \DB::table('blanko2_uploads')
                                    ->where('item_blanko_id', $itemPHO->id)
                                    ->select('id', 'nama_file')
                                    ->first();
                            }

                            // Manual OP
                            $itemManualOP = \DB::table('item_blankos')
                                ->where('evaluasi_blanko_id', $evaluasiBlanko2->id)
                                ->where('nama_item', 'Manual OP')
                                ->first();

                            if ($itemManualOP) {
                                $dokumenManualOP = \DB::table('blanko2_uploads')
                                    ->where('item_blanko_id', $itemManualOP->id)
                                    ->select('id', 'nama_file')
                                    ->first();
                            }

                            // Dokumentasi
                            $itemDokumentasi = \DB::table('item_blankos')
                                ->where('evaluasi_blanko_id', $evaluasiBlanko2->id)
                                ->where('nama_item', 'Dokumentasi')
                                ->first();

                            if ($itemDokumentasi) {
                                $dokumenDokumentasi = \DB::table('blanko2_uploads')
                                    ->where('item_blanko_id', $itemDokumentasi->id)
                                    ->select('id', 'nama_file')
                                    ->first();
                            }
                        }
                    }
                @endphp

                <td class="bg-white">
                    <i class="fas fa-file-contract text-info mr-2"></i>
                    <span class="font-weight-bold text-dark">Kontrak</span>
                </td>
                <td class="text-center bg-white">
                    <button class="btn btn-sm bg-gradient-primary" data-toggle="modal" data-target="#kontrak-show">
                        <span class="fas fa-file-pdf" title="Lihat Dokumen"></span>
                    </button>
                </td>
            </tr>
               <tr>
                <td class="bg-white">
                    <i class="fas fa-drafting-compass text-info mr-2"></i>
                    <span class="font-weight-bold text-dark">As Build Drawing</span>
                </td>
                <td class="text-center bg-white">
                    <button class="btn btn-sm bg-gradient-primary" id="as-build-drawing-button" data-toggle="modal"
                        data-target="#as-build-drawing-show">
                        <span class="fas fa-file-pdf" title="Lihat Dokumen"></span>
                    </button>
                </td>
            </tr>
            <tr>
                <td class="bg-white">
                    <i class="fas fa-certificate text-info mr-2"></i>
                    <span class="font-weight-bold text-dark">PHO</span>
                </td>
                <td class="text-center bg-white">
                    <button class="btn btn-sm bg-gradient-primary" id="pho-button" data-toggle="modal" data-target="#pho-show">
                        <span class="fas fa-file-pdf" title="Lihat Dokumen"></span>
                    </button>
                </td>
            </tr>
            <tr>
                <td class="bg-white">
                    <i class="fas fa-book text-info mr-2"></i>
                    <span class="font-weight-bold text-dark">Manual OP</span>
                </td>
                <td class="text-center bg-white">
                    <button class="btn btn-sm bg-gradient-primary" id="manual-op-button" data-toggle="modal"
                        data-target="#manual-op-show">
                        <span class="fas fa-file-pdf" title="Lihat Dokumen"></span>
                    </button>
                </td>
            </tr>
            <tr>
                <td class="bg-white">
                    <i class="fas fa-camera text-info mr-2"></i>
                    <span class="font-weight-bold text-dark">Dokumentasi</span>
                </td>
                <td class="text-center bg-white">
                    <button class="btn btn-sm bg-gradient-primary" id="dokumentasi-button" data-toggle="modal"
                        data-target="#dokumentasi-show">
                        <span class="fas fa-file-image" title="Lihat Dokumen"></span>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Pembentukan Tim -->
<div class="modal fade" id="pembentukan-tim" tabindex="-1" aria-labelledby="pembentukanTimModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="pembentukanTimModalLabel">
                    <i class="fas fa-upload mr-2"></i> Upload Dokumen Pembentukan Tim
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container">
                    <form id="formPembentukanTim" action="{{ route('pembentukan-tim.store', $jaringan->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="sk_tim_pembina" class="font-weight-bold">SK Tim Pembina</label>
                            <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                                id="sk_tim_pembina" name="sk_tim_pembina">
                        </div>
                        <div class="form-group">
                            <label for="sk_tim_pelaksana" class="font-weight-bold">SK Tim Pelaksana</label>
                            <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                                id="sk_tim_pelaksana" name="sk_tim_pelaksana">
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                                <i class="fas fa-paper-plane mr-2"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pembentukan Tim -->
<div class="modal fade" id="pembentukan-tim-edit" tabindex="-1" aria-labelledby="pembentukanTimEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="pembentukanTimEditModalLabel">
                    <i class="fas fa-edit mr-2"></i> Edit Dokumen Pembentukan Tim
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container">
                    <form id="formPembentukanTimEdit" action="{{ route('pembentukan-tim.update', $jaringan->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="sk_tim_pembina" class="font-weight-bold">SK Tim Pembina</label>
                            <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                                id="sk_tim_pembina" name="sk_tim_pembina">
                            <small class="form-text text-muted"><i>Kosongkan jika tidak mengubah file</i></small>
                        </div>
                        <div class="form-group">
                            <label for="sk_tim_pelaksana" class="font-weight-bold">SK Tim Pelaksana</label>
                            <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                                id="sk_tim_pelaksana" name="sk_tim_pelaksana">
                            <small class="form-text text-muted"><i>Kosongkan jika tidak mengubah file</i></small>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                                <i class="fas fa-paper-plane mr-2"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pembentukan Tim Show -->
<div class="modal fade" id="pembentukan-tim-show" tabindex="-1" aria-labelledby="pembentukanTimShowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="pembentukanTimShowModalLabel">
                    <i class="fas fa-file-alt mr-2"></i> Dokumen Pembentukan Tim
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container">
                    <div class="d-flex justify-content-around my-3">
                        @if ($dokumenPembina)
                        <a href="{{ asset('storage/' . substr($dokumenPembina->path_dokumen, 7)) }}" target="_blank"
                            class="btn bg-gradient-success text-white btn-sm">
                            <i class="fas fa-file-pdf mr-2"></i> Lihat SK Tim Pembina
                        </a>
                        @endif
                        @if ($dokumenPelaksana)
                        <a href="{{ asset('storage/' . substr($dokumenPelaksana->path_dokumen, 7)) }}" target="_blank"
                            class="btn bg-gradient-success text-white btn-sm">
                            <i class="fas fa-file-pdf mr-2"></i> Lihat SK Tim Pelaksana
                        </a>
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="penyusunanRencanaKerjaModalLabel">
                    <i class="fas fa-upload mr-2"></i> Upload Dokumen Penyusunan Rencana Kerja
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container">
                    <form id="formPenyusunanRencanaKerja"
                        action="{{ route('penyusunan-rencana-kerja.store', $jaringan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="penyusunan_rencana_kerja" class="font-weight-bold">Penyusunan Rencana
                                Kerja</label>
                            <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                                id="penyusunan_rencana_kerja" name="penyusunan_rencana_kerja">
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                                <i class="fas fa-paper-plane mr-2"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Penyusunan Rencana Kerja -->
<div class="modal fade" id="penyusunan-rencana-kerja-edit" tabindex="-1"
    aria-labelledby="penyusunanRencanaKerjaEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="penyusunanRencanaKerjaEditModalLabel">
                    <i class="fas fa-edit mr-2"></i> Edit Dokumen Penyusunan Rencana Kerja
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container">
                    <form id="formPenyusunanRencanaKerjaEdit"
                        action="{{ route('penyusunan-rencana-kerja.update', $jaringan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="penyusunan_rencana_kerja" class="font-weight-bold">Penyusunan Rencana
                                Kerja</label>
                            <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                                id="penyusunan_rencana_kerja" name="penyusunan_rencana_kerja">
                            <small class="form-text text-muted"><i>Kosongkan jika tidak mengubah file</i></small>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                                <i class="fas fa-paper-plane mr-2"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show Penyusunan Rencana Kerja -->
<div class="modal fade" id="penyusunan-rencana-kerja-show" tabindex="-1"
    aria-labelledby="penyusunanRencanaKerjaShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="penyusunanRencanaKerjaShowModalLabel">
                    <i class="fas fa-file-alt mr-2"></i> Dokumen Penyusunan Rencana Kerja
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container text-center">
                    @if ($dokumenPenyusunanRencanaKerja)
                    <a href="{{ asset('storage/' . substr($dokumenPenyusunanRencanaKerja->path_dokumen, 7)) }}"
                        target="_blank" class="btn bg-gradient-success text-white btn-sm">
                        <i class="fas fa-file-pdf mr-2"></i> Lihat file Penyusunan Rencana Kerja
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sosialisasi dan Koordinasi -->
<div class="modal fade" id="sosialisai-dan-koordiansi" tabindex="-1" aria-labelledby="sosialisasiModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="sosialisasiModalLabel">
                    <i class="fas fa-upload mr-2"></i> Upload Dokumen Sosialisasi dan Koordinasi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container">
                    <form id="formSosialisasiDanKoordinasi"
                        action="{{ route('sosialisasi-koordinasi.store', $jaringan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="dokumen_sosialisasi" class="font-weight-bold">Dokumen Sosialisasi dan
                                Koordinasi</label>
                            <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                                id="dokumen_sosialisasi" name="dokumen_sosialisasi">
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                                <i class="fas fa-paper-plane mr-2"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Sosialisasi dan Koordinasi -->
<div class="modal fade" id="sosialisasi-dan-koordinasi-edit" tabindex="-1" aria-labelledby="sosialisasiEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="sosialisasiEditModalLabel">
                    <i class="fas fa-edit mr-2"></i> Edit Dokumen Sosialisasi dan Koordinasi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container">
                    <form id="formSosialisasiDanKoordinasiEdit"
                        action="{{ route('sosialisasi-koordinasi.update', $jaringan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="dokumen_sosialisasi" class="font-weight-bold">Dokumen Sosialisasi dan
                                Koordinasi</label>
                            <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                                id="dokumen_sosialisasi" name="dokumen_sosialisasi">
                            <small class="form-text text-muted"><i>Kosongkan jika tidak mengubah file</i></small>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                                <i class="fas fa-paper-plane mr-2"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show Sosialisasi dan Koordinasi -->
<div class="modal fade" id="sosialisasi-dan-koordinasi-show" tabindex="-1" aria-labelledby="sosialisasiShowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="sosialisasiShowModalLabel">
                    <i class="fas fa-file-alt mr-2"></i> Dokumen Sosialisasi dan Koordinasi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container text-center">
                    @if ($dokumenSosialisasi)
                    <a href="{{ asset('storage/' . substr($dokumenSosialisasi->path_dokumen, 7)) }}" target="_blank"
                        class="btn bg-gradient-success text-white btn-sm">
                        <i class="fas fa-file-pdf mr-2"></i> Lihat file Sosialisasi dan Koordinasi
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Uji Pengaliran -->
<div class="modal fade" id="uji-pengaliran" tabindex="-1" aria-labelledby="ujiPengaliranModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="ujiPengaliranModalLabel">
                    <i class="fas fa-upload mr-2"></i> Upload Dokumen Uji Pengaliran
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container">
                    <!-- Upload form uji pengaliran -->
                    <form id="formUjiPengaliran"
                        action="{{ route('inventarisasi-awal-prasarana-air-baku-uji-pengaliran', $jaringan->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="dokumen_uji_pengaliran" class="font-weight-bold">Dokumen Uji
                                Pengaliran</label>
                            <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                                id="dokumen_uji_pengaliran" name="dokumen_uji_pengaliran">
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                                <i class="fas fa-paper-plane mr-2"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Uji Pengaliran -->
<div class="modal fade" id="uji-pengaliran-edit" tabindex="-1" aria-labelledby="ujiPengaliranEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="ujiPengaliranEditModalLabel">
                    <i class="fas fa-edit mr-2"></i> Edit Dokumen Uji Pengaliran
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container">
                    <form id="formUjiPengaliranEdit"
                        action="{{ route('inventarisasi-awal-prasarana-air-baku-uji-pengaliran-update', $jaringan->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="dokumen_uji_pengaliran" class="font-weight-bold">Dokumen Uji
                                Pengaliran</label>
                            <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                                id="dokumen_uji_pengaliran" name="dokumen_uji_pengaliran">
                            <small class="form-text text-muted"><i>Kosongkan jika tidak mengubah file</i></small>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                                <i class="fas fa-paper-plane mr-2"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show Uji Pengaliran -->
<div class="modal fade" id="uji-pengaliran-show" tabindex="-1" aria-labelledby="ujiPengaliranShowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="ujiPengaliranShowModalLabel">
                    <i class="fas fa-file-alt mr-2"></i> Dokumen Uji Pengaliran
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container text-center">
                    @if($dokumenUjiPengaliran)
                    <a href="{{ asset('storage/' . substr($dokumenUjiPengaliran->path_dokumen, 7)) }}" target="_blank"
                        class="btn bg-gradient-success text-white btn-sm">
                        <i class="fas fa-file-pdf mr-2"></i> Lihat Dokumen Uji Pengaliran
                    </a>
                    @else
                    <p class="text-muted">Dokumen belum diupload.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal penyusuan BA Evaluasi Awal Kesiapan OP --}}
<div class="modal fade" id="modal-ba-evaluasi-{{ $jaringan->id }}" tabindex="-1" aria-labelledby="modalBAEvaluasiLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="modalBAEvaluasiLabel">
                    <i class="fas fa-info-circle mr-2"></i> Penyusunan BA Hasil Evaluasi Awal Kesiapan OP: <strong>{{$jaringan->nama }}</strong>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead class="bg-gradient-primary text-white table-sm text-center">
                                <tr>
                                    <th>No.</th>
                                    <th>Kriteria dan Rekomendasi</th>
                                    <th class="w-25">SIAP OP (Dengan Catatan)</th>
                                    <th class="w-25">SIAP OP</th>
                                    <th class="w-25">Hasil</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-light">
                                    <td>1</td>
                                    <td class="text-bold">KESIAPAN DATA DAN INFORMASI PEKERJAAN FISIK</td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: 100%</li>
                                            <li>Kondisi: > 70%</li>
                                            <li>Fungsi: > 70%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 100%</li>
                                            <li>Kondisi: > 80%</li>
                                            <li>Fungsi: > 80%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            {{-- ini blanko 1 --}}
                                            <li class="" id="hasil-ada-tidak-ada-1">Keberadaannya:</li>
                                            <li class="" id="hasil-kondisi-1">Kondisi:</li>
                                            <li class="" id="hasil-fungsi-1">Fungsi:</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr class="bg-light">
                                    <td>2</td>
                                    <td class="text-bold">KESIAPAN DATA DAN INFORMASI PEKERJAAN NON-FISIK</td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 70%</li>
                                            <li>Kondisi: > 70%</li>
                                            <li>Fungsi: > 70%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 80%</li>
                                            <li>Kondisi: > 80%</li>
                                            <li>Fungsi: > 80%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li id="hasil-ada-tidak-ada-2">Keberadaannya:</li>
                                            <li>Kondisi: -</li>
                                            <li>Fungsi: -</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr class="bg-light">
                                    <td rowspan="6">3</td>
                                    <td class="text-bold border-right-0">KESIAPAN SARANA DAN PRASARANA PENDUKUNG
                                        PENGELOLA AIR TANAH DAN AIR BAKU</td>
                                    <td colspan="3"></td>
                                </tr>
                                <tr class="bg-light">
                                    <td class="text-bold">a. SARANA PENUNJANG OP TERPENUHI</td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 80%</li>
                                            <li>Kondisi: > 70%</li>
                                            <li>Fungsi: > 70%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 100%</li>
                                            <li>Kondisi: > 80%</li>
                                            <li>Fungsi: > 80%</li>
                                           
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li id="hasil-ada-tidak-ada-3A">Keberadaannya:</li>
                                            <li>Kondisi: -</li>
                                            <li>Fungsi: -</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr class="bg-light">
                                    <td class="text-bold">b. KELEMBAGAAN DAN SDM TERPENUHI</td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 60%</li>
                                            <li>Kondisi: > 60%</li>
                                            <li>Fungsi: > 60%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 80%</li>
                                            <li>Kondisi: > 80%</li>
                                            <li>Fungsi: > 80%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li id="hasil-ada-tidak-ada-3B">Keberadaannya:</li>
                                            <li>Kondisi: -</li>
                                            <li>Fungsi: -</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr class="bg-light">
                                    <td class="text-bold">c. MANAJEMEN TERPENUHI</td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 60%</li>
                                            <li>Kondisi: > 60%</li>
                                            <li>Fungsi: > 60%</li>     
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 80%</li>
                                            <li>Kondisi: > 80%</li>
                                            <li>Fungsi: > 80%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li id="hasil-ada-tidak-ada-3C">Keberadaannya:</li>
                                            <li>Kondisi: -</li>
                                            <li>Fungsi: -</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr class="bg-light">
                                    <td class="text-bold">d. KONSERVASI TERPENUHI</td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 60%</li>
                                            <li>Kondisi: > 60%</li>
                                            <li>Fungsi: > 60%</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Keberadaannya: > 80%</li>
                                            <li>Kondisi: > 80%</li>
                                            <li>Fungsi: > 80%</li>

                                        </ul>
                                    </td>
                                    <td>
                                        <ul>
                                            <li id="hasil-ada-tidak-ada-3D">Keberadaannya:</li>
                                            <li>Kondisi: -</li>
                                            <li>Fungsi: -</li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Alerts for recommendations -->
                        <div class="mt-5">
                            <div id="recommendation-success" class="d-none">
                                Rekomendasi: SIAP OP
                            </div>
                            <div id="recommendation-warning" class="d-none">
                                Rekomendasi: SIAP OP dengan Catatan
                            </div>
                            <div id="recommendation-failure" class="d-none">
                                Rekomendasi: Belum SIAP OP
                            </div>
                        </div>
                    
                        {{-- <p>Upload BA Hasil Evaluasi Awal Kesiapan OP</p> --}}
                    </div>
                </div>
                <div class="text-right mt-5">
                    <button type="button" class="btn bg-gradient-danger text-white btn-sm" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload BA Evaluasi Awal -->
<div class="modal fade" id="upload-ba-evaluasi-awal" tabindex="-1" aria-labelledby="uploadBAEvaluasiAwalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="uploadBAEvaluasiAwalLabel">
                    <i class="fas fa-upload mr-2"></i> Upload Dokumen BA Evaluasi Awal Kesiapan OP
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <form id="formUploadBAEvaluasiAwal" action="{{ route('upload-ba-evaluasi-awal', $jaringan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="dokumen_ba_evaluasi_awal" class="font-weight-bold">Dokumen BA Evaluasi Awal</label>
                        <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                            id="dokumen_ba_evaluasi_awal" name="dokumen_ba_evaluasi_awal" required>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                            <i class="fas fa-paper-plane mr-2"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit BA Evaluasi Awal -->
<div class="modal fade" id="edit-ba-evaluasi-awal" tabindex="-1" aria-labelledby="editBAEvaluasiAwalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="editBAEvaluasiAwalLabel">
                    <i class="fas fa-edit mr-2"></i> Edit Dokumen BA Evaluasi Awal Kesiapan OP
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <form id="formEditBAEvaluasiAwal" action="{{ route('update-upload-ba-evaluasi-awal', $jaringan->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="dokumen_ba_evaluasi_awal" class="font-weight-bold">Dokumen BA Evaluasi Awal</label>
                        <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                            id="dokumen_ba_evaluasi_awal" name="dokumen_ba_evaluasi_awal">
                        <small class="form-text text-muted"><i>Kosongkan jika tidak mengubah file</i></small>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                            <i class="fas fa-paper-plane mr-2"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show BA Evaluasi Awal -->
<div class="modal fade" id="show-ba-evaluasi-awal" tabindex="-1" aria-labelledby="showBAEvaluasiAwalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="showBAEvaluasiAwalLabel">
                    <i class="fas fa-file-pdf mr-2"></i> Dokumen BA Evaluasi Awal Kesiapan OP
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container text-center">
                    @if($dokumenEvaluasiAwal)
                    <a href="{{ asset('storage/' .substr($dokumenEvaluasiAwal->path_dokumen, 7)) }}" target="_blank"
                        class="btn bg-gradient-success text-white btn-sm">
                        <i class="fas fa-file-pdf mr-2"></i> Lihat Dokumen BA Evaluasi Awal Kesiapan OP
                    </a>
                    @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Dokumen BA Evaluasi Awal belum diunggah.
                    </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
           
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Evaluasi Akhir Kesiapan OP -->
<div class="modal fade" id="upload-evaluasi-akhir" tabindex="-1" aria-labelledby="uploadEvaluasiAkhirLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="uploadEvaluasiAkhirLabel">
                    <i class="fas fa-upload mr-2"></i> Upload Dokumen Evaluasi Akhir Kesiapan OP
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <form id="formUploadEvaluasiAkhir" action="{{ route('upload-evaluasi-akhir', $jaringan->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="dokumen_evaluasi_akhir" class="font-weight-bold">Dokumen Evaluasi Akhir</label>
                        <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                            id="dokumen_evaluasi_akhir" name="dokumen_evaluasi_akhir" required>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                            <i class="fas fa-paper-plane mr-2"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Evaluasi Akhir Kesiapan OP -->
<div class="modal fade" id="edit-evaluasi-akhir" tabindex="-1" aria-labelledby="editEvaluasiAkhirLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="editEvaluasiAkhirLabel">
                    <i class="fas fa-edit mr-2"></i> Edit Dokumen Evaluasi Akhir Kesiapan OP
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <form id="formEditEvaluasiAkhir" action="{{ route('update-upload-evaluasi-akhir', $jaringan->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="dokumen_evaluasi_akhir" class="font-weight-bold">Dokumen Evaluasi Akhir</label>
                        <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                            id="dokumen_evaluasi_akhir" name="dokumen_evaluasi_akhir">
                        <small class="form-text text-muted"><i>Kosongkan jika tidak mengubah file</i></small>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                            <i class="fas fa-paper-plane mr-2"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show Evaluasi Akhir Kesiapan OP -->
<div class="modal fade" id="show-evaluasi-akhir" tabindex="-1" aria-labelledby="showEvaluasiAkhirLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="showEvaluasiAkhirLabel">
                    <i class="fas fa-file-alt mr-2"></i> Dokumen Evaluasi Akhir Kesiapan OP
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container text-center">
                    @if ($dokumenEvaluasiAkhir)
                    <a href="{{ asset('storage/' . substr($dokumenEvaluasiAkhir->path_dokumen, 7)) }}" target="_blank"
                        class="btn bg-gradient-success text-white btn-sm">
                        <i class="fas fa-file-pdf mr-2"></i> Lihat Dokumen Evaluasi Akhir Kesiapan OP
                    </a>
                    @else
                    <p class="text-muted">Dokumen belum diupload.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload BA Evaluasi Akhir Kesipan OP -->
<div class="modal fade" id="upload-ba-evaluasi-akhir" tabindex="-1" aria-labelledby="uploadBAEvaluasiAkhirLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="uploadBAEvaluasiAkhirLabel">
                    <i class="fas fa-upload mr-2"></i> Upload Dokumen BA Hasil Evaluasi Akhir Kesiapan OP
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <form id="formUploadBAEvaluasiAkhir" action="{{ route('upload-ba-evaluasi-akhir', $jaringan->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="dokumen_ba_evaluasi_akhir" class="font-weight-bold">Dokumen BA Evaluasi
                            Akhir</label>
                        <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                            id="dokumen_ba_evaluasi_akhir" name="dokumen_ba_evaluasi_akhir" required>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                            <i class="fas fa-paper-plane mr-2"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit BA Evaluasi Akhir Kesiapan OP -->
<div class="modal fade" id="edit-ba-evaluasi-akhir" tabindex="-1" aria-labelledby="editBAEvaluasiAkhirLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="editBAEvaluasiAkhirLabel">
                    <i class="fas fa-edit mr-2"></i> Edit Dokumen BA Hasil Evaluasi Akhir Kesiapan OP
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <form id="formEditBAEvaluasiAkhir"
                    action="{{ route('update-upload-ba-evaluasi-akhir', $jaringan->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="dokumen_ba_evaluasi_akhir" class="font-weight-bold">Dokumen BA Evaluasi
                            Akhir</label>
                        <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                            id="dokumen_ba_evaluasi_akhir" name="dokumen_ba_evaluasi_akhir">
                        <small class="form-text text-muted"><i>Kosongkan jika tidak mengubah file</i></small>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                            <i class="fas fa-paper-plane mr-2"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show BA Evaluasi Akhir Kesiapan OP -->
<div class="modal fade" id="show-ba-evaluasi-akhir" tabindex="-1" aria-labelledby="showBAEvaluasiAkhirLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="showBAEvaluasiAkhirLabel">
                    <i class="fas fa-file-alt mr-2"></i> Dokumen BA Hasil Evaluasi Akhir Kesiapan OP
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container text-center">
                    @if ($dokumenBAEvaluasiAkhir)
                    <a href="{{ asset('storage/' . substr($dokumenBAEvaluasiAkhir->path_dokumen, 7)) }}" target="_blank"
                        class="btn bg-gradient-success text-white btn-sm">
                        <i class="fas fa-file-pdf mr-2"></i> Lihat Dokumen
                    </a>
                    @else
                    <p class="text-muted">Dokumen belum diupload.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Serah Terima OP -->
<div class="modal fade" id="upload-serah-terima-op" tabindex="-1" aria-labelledby="uploadSerahTerimaOPLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="uploadSerahTerimaOPLabel">
                    <i class="fas fa-upload mr-2"></i> Upload Dokumen Serah Terima Hasil OP
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <form id="formUploadSerahTerimaOP" action="{{ route('upload-serah-terima-op', $jaringan->id) }}"   enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="dokumen_serah_terima_op" class="font-weight-bold">Dokumen Serah Terima OP</label>
                        <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                            id="dokumen_serah_terima_op" name="dokumen_serah_terima_op" required>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                            <i class="fas fa-paper-plane mr-2"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Serah Terima OP -->
<div class="modal fade" id="edit-serah-terima-op" tabindex="-1" aria-labelledby="editSerahTerimaOPLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="editSerahTerimaOPLabel">
                    <i class="fas fa-edit mr-2"></i> Edit Dokumen Serah Terima Hasil OP
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <form id="formEditSerahTerimaOP" action="{{ route('update-upload-serah-terima-op', $jaringan->id) }}"" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="dokumen_serah_terima_op" class="font-weight-bold">Dokumen Serah Terima OP</label>
                        <input type="file" accept="application/pdf" class="form-control-file border rounded p-2"
                            id="dokumen_serah_terima_op" name="dokumen_serah_terima_op">
                        <small class="form-text text-muted"><i>Kosongkan jika tidak mengubah file</i></small>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn bg-gradient-success text-white btn-sm">
                            <i class="fas fa-paper-plane mr-2"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show Serah Terima OP -->
<div class="modal fade" id="show-serah-terima-op" tabindex="-1" aria-labelledby="showSerahTerimaOPLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="showSerahTerimaOPLabel">
                    <i class="fas fa-file-alt mr-2"></i> Dokumen Serah Terima Hasil OP
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container text-center">
                    @if($dokumenSerahTerima)
                    <a href="{{ asset('storage/' . substr($dokumenSerahTerima->path_dokumen, 7)) }}" target="_blank"
                        class="btn bg-gradient-success text-white btn-sm">
                        <i class="fas fa-file-pdf mr-2"></i> Lihat Dokumen Serah Terima OP
                    </a>
                    @else
                    <p class="text-muted">Dokumen belum diupload.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show Kontrak -->
<div class="modal fade" id="kontrak-show" tabindex="-1" aria-labelledby="kontrakShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="kontrakShowModalLabel">
                    <i class="fas fa-file-alt mr-2"></i> Dokumen Kontrak
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container text-center">
                    @if ($dokumenKontrak)
                    <a href="{{ asset('storage/blanko2/' . $dokumenKontrak->nama_file) }}" target="_blank"
                        class="btn bg-gradient-success text-white btn-sm">
                        <i class="fas fa-file-pdf mr-2"></i> Lihat file Kontrak
                    </a>
                    @else
                    <p class="text-muted">Dokumen belum diupload.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show As Build Drawing -->
<div class="modal fade" id="as-build-drawing-show" tabindex="-1" aria-labelledby="asBuildDrawingShowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="asBuildDrawingShowModalLabel">
                    <i class="fas fa-drafting-compass mr-2"></i> Dokumen As Build Drawing
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container text-center">
                    @if ($dokumenAsBuildDrawing)
                    <a href="{{ asset('storage/blanko2/' . $dokumenAsBuildDrawing->nama_file) }}" target="_blank"
                        class="btn bg-gradient-success text-white btn-sm">
                        <i class="fas fa-file-pdf mr-2"></i> Lihat file As Build Drawing
                    </a>
                    @else
                    <p class="text-muted">Dokumen belum diupload.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show PHO -->
<div class="modal fade" id="pho-show" tabindex="-1" aria-labelledby="phoShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="phoShowModalLabel">
                    <i class="fas fa-certificate mr-2"></i> Dokumen PHO
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container text-center">
                    @if ($dokumenPHO)
                    <a href="{{ asset('storage/blanko2/' . $dokumenPHO->nama_file) }}" target="_blank"
                        class="btn bg-gradient-success text-white btn-sm">
                        <i class="fas fa-file-pdf mr-2"></i> Lihat file PHO
                    </a>
                    @else
                    <p class="text-muted">Dokumen belum diupload.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show Manual OP -->
<div class="modal fade" id="manual-op-show" tabindex="-1" aria-labelledby="manualOPShowModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="manualOPShowModalLabel">
                    <i class="fas fa-book mr-2"></i> Dokumen Manual OP
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container text-center">
                    @if ($dokumenManualOP)
                    <a href="{{ asset('storage/blanko2/' . $dokumenManualOP->nama_file) }}" target="_blank"
                        class="btn bg-gradient-success text-white btn-sm">
                        <i class="fas fa-file-pdf mr-2"></i> Lihat file Manual OP
                    </a>
                    @else
                    <p class="text-muted">Dokumen belum diupload.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Show Dokumentasi -->
<div class="modal fade" id="dokumentasi-show" tabindex="-1" aria-labelledby="dokumentasiShowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="dokumentasiShowModalLabel">
                    <i class="fas fa-camera mr-2"></i>Dokumentasi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="container text-center">
                    @if ($dokumenDokumentasi)
                    <a href="{{ asset('storage/blanko2/' . $dokumenDokumentasi->nama_file) }}" target="_blank"
                        class="btn bg-gradient-success text-white btn-sm">
                        <i class="fas fa-file-image mr-2"></i> Lihat file Dokumentasi
                    </a>
                    @else
                    <p class="text-muted">Dokumen belum diupload.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('jaringan-atab.index') }}"
    class="btn bg-gradient-warning btn-sm mb-3 d-flex align-items-center justify-content-center"
    style="border-radius: 30px; padding: 8px 15px; font-weight: bold; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: transform 0.2s ease;">
    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Database
</a>
@stop

@section('css')
@stop

@section('js')
<script>
    $(document).ready(function () {
        let newWindow;

        function openNewWindow(url, buttonId) {
            // Disable all buttons
            $('button').prop('disabled', true);

            // Open the new window
            newWindow = window.open(url, '_blank', 'width=1000,height=600,resizable=no');

            // Check if the window was blocked
            if (!newWindow || newWindow.closed || typeof newWindow.closed == 'undefined') {
                alert('Please allow popups for this website');
                $('button').prop('disabled', false); // Enable all buttons again if the window was blocked
            } else {
                // Monitor the newly opened window and enable buttons when it's closed
                let windowChecker = setInterval(function () {
                    if (newWindow.closed) {
                        clearInterval(windowChecker);
                        $('button').prop('disabled', false); // Enable all buttons
                    }
                }, 1000);
            }
        }

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

        //-----FORM UJI PENGALIRAN---------//
        $('#formUjiPengaliran').on('submit', function (e) {
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
                    $('#uji-pengaliran').modal('hide');
                    alert('Dokumen berhasil diupload.');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.log("Error:", error);
                    alert('Gagal mengupload dokumen. Silakan coba lagi.');
                }
            });
        });

        //-----FORM EDIT UJI PENGALIRAN---------//
        $('#formUjiPengaliranEdit').on('submit', function (e) {
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
                    $('#uji-pengaliran-edit').modal('hide');
                    alert('Dokumen berhasil diperbarui.');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.log("Error:", error);
                    alert('Gagal memperbarui dokumen. Silakan coba lagi.');
                }
            });
        });

        //-----FORM PENYUSUSNA BA Evaluasi AWAL KESIPAN OP---------//
        $('#formUploadBAEvaluasiAwal').on('submit', function (e) {
            e.preventDefault();
            
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert('Dokumen berhasil diupload.');
                    location.reload(); // Refresh halaman untuk memperbarui status
                },
                error: function (xhr) {
                    alert('Gagal mengupload dokumen. Silakan coba lagi.');
                }
            });
        });

        //-----FORM EDIT BA Evaluasi Awal KESIPAN OP---------//
        $('#formEditBAEvaluasiAwal').on('submit', function (e) {
            e.preventDefault();
            
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert('Dokumen berhasil diperbarui.');
                    location.reload(); // Refresh halaman untuk memperbarui status
                },
                error: function (xhr) {
                    alert('Gagal memperbarui dokumen. Silakan coba lagi.');
                }
            });
        });

        //-----FORM UPLOAD EVALUASI AKHIR KESIAPAN OP---------//
        $('#formUploadEvaluasiAkhir').on('submit', function (e) {
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
                    $('#upload-evaluasi-akhir').modal('hide');
                    alert('Dokumen berhasil diupload.');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.log("Error:", error);
                    alert('Gagal mengupload dokumen. Silakan coba lagi.');
                }
            });
        });

        //-----FORM EDIT EVALUASI AKHIR KESIAPAN OP---------//
        $('#formEditEvaluasiAkhir').on('submit', function (e) {
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
                    $('#edit-evaluasi-akhir').modal('hide');
                    alert('Dokumen berhasil diupdate.');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.log("Error:", error);
                    alert('Gagal mengupdate dokumen. Silakan coba lagi.');
                }
            });
        });

        //-----FORM UPLOAD BA HASIL EVALUASI AKHIR KESIAPAN OP---------//
        $('#formUploadBAEvaluasiAkhir').on('submit', function (e) {
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
                    $('#upload-ba-evaluasi-akhir').modal('hide');
                    alert('Dokumen berhasil diupload.');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.log("Error:", error);
                    alert('Gagal mengupload dokumen. Silakan coba lagi.');
                }
            });
        });

        //-----FORM EDIT BA HASIL EVALUASI AKHIR KESIAPAN OP---------//
        $('#formEditBAEvaluasiAkhir').on('submit', function (e) {
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
                    $('#edit-ba-evaluasi-akhir').modal('hide');
                    alert('Dokumen berhasil diupdate.');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.log("Error:", error);
                    alert('Gagal mengupdate dokumen. Silakan coba lagi.');
                }
            });
        });

        //-----FORM UPLOAD SERTAH TERIMA OP---------//
        $('#formUploadSerahTerimaOP').on('submit', function (e) {
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
                    $('#upload-serah-terima-op').modal('hide');
                    alert('Dokumen Serah Terima OP berhasil diupload.');
                    location.reload(); // Refresh halaman untuk memperbarui status
                },
                error: function (xhr, status, error) {
                    console.log("Error:", error);
                    alert('Gagal mengupload dokumen. Silakan coba lagi.');
                }
            });
        });

        //-----FORM EDIT SERAH TERIMA OP---------//
        $('#formEditSerahTerimaOP').on('submit', function (e) {
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
                    $('#edit-serah-terima-op').modal('hide');
                    alert('Dokumen Serah Terima OP berhasil diperbarui.');
                    location.reload(); // Refresh halaman untuk memperbarui status
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
            evaluasiAwalButton.addEventListener('click', function () {
                var url = "{{ route('evaluasi-awal', ['jaringan' => $jaringan->id]) }}";
                openNewWindow(url, this.id);
            });
        }

        //-----Halaman FORM Prasarana Air Tanah---------//
        var prasaranaAirTanahButton = document.getElementById('prasarana-air-tanah-button');
        if (prasaranaAirTanahButton) {
            prasaranaAirTanahButton.addEventListener('click', function () {
                var url = "{{ route('inventarisasi-awal-prasarana-air-tanah', ['jaringan' => $jaringan->id]) }}";
                openNewWindow(url, this.id);
            });
        }

        //-----Halaman FORM Peralatan Air Tanah---------//
        var peralatanAirTanahButton = document.getElementById('peralatan-air-tanah-button');
        if (peralatanAirTanahButton) {
            peralatanAirTanahButton.addEventListener('click', function () {
                var url = "{{ route('inventarisasi-awal-peralatan-air-tanah', ['jaringan' => $jaringan->id]) }}";
                openNewWindow(url, this.id);
            });
        }

        //-----Halaman FORM Prasarana Air Baku---------//
        var prasaranaAirBakuButton = document.getElementById('prasarana-air-baku-button');
        if (prasaranaAirBakuButton) {
            prasaranaAirBakuButton.addEventListener('click', function () {
                var url = "{{ route('inventarisasi-awal-prasarana-air-baku', ['jaringan' => $jaringan->id]) }}";
                openNewWindow(url, this.id);
            });
        }

        //-----Halaman Form Data dan Informasi Non-Fisik---------//
        var dataInformasiNonFisikButton = document.getElementById('data-dan-informasi-non-fisik-button');
        if (dataInformasiNonFisikButton) {
            dataInformasiNonFisikButton.addEventListener('click', function () {
                var url = "{{ route('inventarisasi-awal-data-informasi-non-fisik', ['jaringan' => $jaringan->id]) }}";
                openNewWindow(url, this.id);
            });
        }

        //-----Halaman Kesiapan Sarana Penunjang Operasi dan Pemeliharaan---------//
        var kesiapanSaranaPenunjangOperasiDanPemeliharaanButton = document.getElementById('kesiapan-sarana-penunjang-operasi-dan-pemeliharaan-button');
        if (kesiapanSaranaPenunjangOperasiDanPemeliharaanButton) {
            kesiapanSaranaPenunjangOperasiDanPemeliharaanButton.addEventListener('click', function () {
                var url = "{{ route('inventarisasi-awal-kesiapan-sarana-penunjang-op', ['jaringan' => $jaringan->id]) }}";
                openNewWindow(url, this.id);
            });
        }

        //-----Halaman Kesiapan Kelembagaan dan Sumber Daya Manusia---------//
        var kesiapanKelembagaanDanSumberDayaManusiaButton = document.getElementById('kesiapan-kelembagaan-dan-sumber-daya-manusia-button');
        if (kesiapanKelembagaanDanSumberDayaManusiaButton) {
            kesiapanKelembagaanDanSumberDayaManusiaButton.addEventListener('click', function () {
                var url = "{{ route('inventarisasi-awal-kesiapan-kelembagaan-sdm', ['jaringan' => $jaringan->id]) }}";
                openNewWindow(url, this.id);
            });
        }

        //-----Halaman Kesiapan Manajemen---------//
        var kesiapanManajemenButton = document.getElementById('kesiapan-manajemen-button');
        if (kesiapanManajemenButton) {
            kesiapanManajemenButton.addEventListener('click', function () {
                var url = "{{ route('inventarisasi-awal-kesiapan-manajemen', ['jaringan' => $jaringan->id]) }}";
                openNewWindow(url, this.id);
            });
        }

        //-----Halaman Kesiapan Konservasi---------//
        var kesiapanKonservasiButton = document.getElementById('kesiapan-konservasi-button');
        if (kesiapanKonservasiButton) {
            kesiapanKonservasiButton.addEventListener('click', function () {
                var url = "{{ route('inventarisasi-awal-kesiapan-konservasi', ['jaringan' => $jaringan->id]) }}";
                openNewWindow(url, this.id);
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

{{-- ini untuk penyusunan BA Evaluasi Awal Kesiapan OP --}}
<script>
    $(document).ready(function () {
    $('#modal-ba-evaluasi-{{ $jaringan->id }}').on('shown.bs.modal', function () {
        // Kosongkan elemen-elemen yang akan diisi ulang
        $('#hasil-ada-tidak-ada-1 span').remove();
        $('#hasil-kondisi-1 span').remove();
        $('#hasil-fungsi-1 span').remove();
        $('#hasil-ada-tidak-ada-2 span').remove();
        $('#hasil-ada-tidak-ada-3A span').remove();
        $('#hasil-ada-tidak-ada-3B span').remove();
        $('#hasil-ada-tidak-ada-3C span').remove();
        $('#hasil-ada-tidak-ada-3D span').remove();

        $.ajax({
            url: "{{ route('api.ba-awal-kesiapan-op', $jaringan) }}",
            type: "GET",
            success: function (data) {
                //console.log(data);
                
                // Function to determine badge color based on value and thresholds
                function getBadgeColor(value, catatanThreshold, siapThreshold) {
                    if (value >= siapThreshold) {
                        return 'badge-success'; // Hijau
                    } else if (value >= catatanThreshold && value < siapThreshold) {
                        return 'badge-warning'; // Kuning
                    } else {
                        return 'badge-danger'; // Merah
                    }
                }

                // Function to add badge with appropriate color and value
                function addBadge(elementId, value, catatanThreshold, siapThreshold) {
                    let badgeColor = getBadgeColor(value, catatanThreshold, siapThreshold);
                    let titleText = `${value}%`;

                    $(`#${elementId}`).append(`<span class="badge ${badgeColor} ml-2" style="font-size: 15px;" title="${titleText}">${value}%</span>`);
                }

                // Tampilkan hasil Blanko 1
                addBadge('hasil-ada-tidak-ada-1', data.blanko1.hasil_ada_tidak_ada || 0, 70, 80);
                addBadge('hasil-kondisi-1', data.blanko1.hasil_kondisi || 0, 70, 80);
                addBadge('hasil-fungsi-1', data.blanko1.hasil_fungsi || 0, 70, 80);

                // Tampilkan hasil Blanko 2
                addBadge('hasil-ada-tidak-ada-2', data.blanko2.hasil_ada_tidak_ada || 0, 70, 80);

                // Tampilkan hasil Blanko 3A, 3B, 3C, 3D
                addBadge('hasil-ada-tidak-ada-3A', data.blanko3.blanko3A.hasil_ada_tidak_ada || 0, 70, 80);
                addBadge('hasil-ada-tidak-ada-3B', data.blanko3.blanko3B.hasil_ada_tidak_ada || 0, 60, 80);
                addBadge('hasil-ada-tidak-ada-3C', data.blanko3.blanko3C.hasil_ada_tidak_ada || 0, 60, 80);
                addBadge('hasil-ada-tidak-ada-3D', data.blanko3.blanko3D.hasil_ada_tidak_ada || 0, 60, 80);

                // Tampilkan rekomendasi
                if (data.recommendation === 'SIAP OP') {
                    $('#recommendation-success')
                        .removeClass('d-none')
                        .show()
                        .css({
                            'background-color': '#28a745', // hijau
                            'color': '#ffffff', // teks putih
                            'padding': '10px', // padding
                            'border-radius': '5px', // border radius
                            'font-weight': 'bold', // teks tebal
                            'text-align': 'center' // teks tengah
                        });
                } else if (data.recommendation === 'SIAP OP dengan Catatan') {
                    $('#recommendation-warning')
                        .removeClass('d-none')
                        .show()
                        .css({
                            'background-color': '#ffc107', // kuning
                            'color': '#000000', // teks hitam
                            'padding': '10px', // padding
                            'border-radius': '5px', // border radius
                            'font-weight': 'bold', // teks tebal
                            'text-align': 'center' // teks tengah
                        });
                } else if (data.recommendation === 'Belum SIAP OP') {
                    $('#recommendation-failure')
                        .removeClass('d-none')
                        .show()
                        .css({
                            'background-color': '#dc3545', // merah
                            'color': '#ffffff', // teks putih
                            'padding': '10px', // padding
                            'border-radius': '5px', // border radius
                            'font-weight': 'bold', // teks tebal
                            'text-align': 'center' // teks tengah
                        });
                }
            }
        });
    });
});

</script>
@stop