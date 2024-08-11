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
                            <th class="text-muted"><i class="fas fa-water mr-2"></i>Wilayah Sungai</th>
                            <td class="font-weight-bold text-dark">{{ $jaringan->wilayah_sungai }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted"><i class="fas fa-stream mr-2"></i>Jenis</th>
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
                        <div class="collapse show" id="collapseInventarisasi">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="bg-white">
                        <i class="fas fa-file-signature fa-lg text-primary mr-2"></i>
                        <span class="font-weight-bold text-dark">Penyusunan BA Hasil Evaluasi Awal Kesiapan OP</span>
                    </td>
                    <td class="bg-white"></td>
                    <td class="bg-white"></td>
                </tr>
                <tr>
                    <td class="bg-white">
                        <i class="fas fa-clipboard-check fa-lg text-primary mr-2"></i>
                        <span class="font-weight-bold text-dark">Evaluasi Akhir Kesiapan OP</span>
                    </td>
                    <td class="bg-white"></td>
                    <td class="bg-white"></td>
                </tr>
                <tr>
                    <td class="bg-white">
                        <i class="fas fa-file-alt fa-lg text-primary mr-2"></i>
                        <span class="font-weight-bold text-dark">Penyusunan BA Hasil Evaluasi Akhir Kesiapan OP</span>
                    </td>
                    <td class="bg-white"></td>
                    <td class="bg-white"></td>
                </tr>
                <tr>
                    <td class="bg-white">
                        <i class="fas fa-handshake fa-lg text-success mr-2"></i>
                        <span class="font-weight-bold text-dark">Serah Terima Hasil OP</span>
                    </td>
                    <td class="bg-white"></td>
                    <td class="bg-white">
                        <button class="btn bg-gradient-primary btn-sm" data-toggle="modal" data-target="#serah-terima">
                            <span class="fas fa-upload" title="Upload Dokumen"></span>
                        </button>
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
                    <td class="bg-white">
                        <i class="fas fa-file-contract text-info mr-2"></i>
                        <span class="font-weight-bold text-dark">Kontrak</span>
                    </td>
                    <td class="text-center bg-white">
                        <button class="btn btn-sm bg-gradient-primary" id="kontrak-button" data-toggle="modal"
                            data-target="#dokumen-kontrak">
                            <span class="fas fa-eye" title="Lihat Dokumen"></span>
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
                            data-target="#as-build-drawing">
                            <span class="fas fa-eye" title="Lihat Dokumen"></span>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="bg-white">
                        <i class="fas fa-certificate text-info mr-2"></i>
                        <span class="font-weight-bold text-dark">PHO/FHO</span>
                    </td>
                    <td class="text-center bg-white">
                        <button class="btn btn-sm bg-gradient-primary" id="pho-fho-button" data-toggle="modal"
                            data-target="#pho-fho">
                            <span class="fas fa-eye" title="Lihat Dokumen"></span>
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
                            data-target="#manual-op">
                            <span class="fas fa-eye" title="Lihat Dokumen"></span>
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
                            data-target="#dokumentasi">
                            <span class="fas fa-eye" title="Lihat Dokumen"></span>
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
                        class="btn bg-gradient-info text-white btn-sm">
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
                        class="btn bg-gradient-info text-white btn-sm">
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
            newWindow = window.open(url, '_blank', 'width=900,height=600,resizable=no');

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
@stop