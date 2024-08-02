<?php

namespace App\Listeners;

use App\Models\Jaringan;
use App\Models\Tahapan;
use App\Models\EvaluasiBlanko;
use App\Models\ItemBlanko;
use App\Models\ItemBlanko3;
use App\Models\ItemBlanko3Rincian;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateTahapansForJaringan
{
    /**
     * Handle the event.
     *
     * @param  \App\Models\Jaringan  $jaringan
     * @return void
     */
    public function handle(Jaringan $jaringan)
    {
        $tahapans = [
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Pembentukan Tim', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Penyusunan Rencana Kerja', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Sosialisasi dan Koordinasi', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Evaluasi Awal Kesiapan', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Upload Dokumen Utama', 'nilai' => null],
        ];

        foreach ($tahapans as $tahapan) {
            $createdTahapan = Tahapan::create($tahapan);

            // Buat Evaluasi Blanko 1A untuk Tahapan 'Evaluasi Awal Kesiapan'
            if ($createdTahapan->nama_tahapan === 'Evaluasi Awal Kesiapan') {
                $evaluasiBlanko1A = EvaluasiBlanko::create([
                    'tahapan_id' => $createdTahapan->id,
                    'jenis_blanko' => 'Blanko 1A',
                ]);

                // Data item blanko 1A
                $items1A = [
                    ['nama_item' => 'Sumur'],
                    ['nama_item' => 'Pompa dan aksesoris'],
                    ['nama_item' => 'Penggerak Pompa (Listrik/Genset/Solar Cell)'],
                    ['nama_item' => 'Rumah Pompa'],
                    ['nama_item' => 'Jaringan air tanah'],
                    ['nama_item' => 'Rumah jaga'],
                    ['nama_item' => 'Pagar pengaman'],
                    ['nama_item' => 'Jalan masuk'],
                    ['nama_item' => 'Alat ukur'],
                    ['nama_item' => 'Hidran umum'],
                    ['nama_item' => 'Reservoir'],
                ];

                // Insert item blanko 1A ke database
                foreach ($items1A as $item) {
                    ItemBlanko::create([
                        'evaluasi_blanko_id' => $evaluasiBlanko1A->id,
                        'nama_item' => $item['nama_item'],
                        'ada_tidak_ada' => 0,
                        'bobot' => 0,
                        'kondisi' => 0,
                        'fungsi' => 0,
                        'keterangan' => '',
                    ]);
                }

                //buat Evaluasi Blanko 1B untuk Tahapan 'Evaluasi Awal Kesiapan'
                $evaluasiBlanko1B = EvaluasiBlanko::create([
                    'tahapan_id' => $createdTahapan->id,
                    'jenis_blanko' => 'Blanko 1B',
                ]);

                // Data item blanko 1B
                $items1B = [
                    ['nama_item' => 'Mesin bor dan kendaraan pengangkutnya'],
                    ['nama_item' => 'Kompresor'],
                    ['nama_item' => 'Genset'],
                    ['nama_item' => 'Mesin las'],
                    ['nama_item' => 'Truk Crane'],
                    ['nama_item' => 'Mobil Water Tank'],
                    ['nama_item' => 'Pompa Air'],
                    ['nama_item' => 'Pompa lumpur'],
                    ['nama_item' => 'Set mata bor'],
                    ['nama_item' => 'Mixer bentonait'],
                    ['nama_item' => 'Peralatan Logging'],
                ];

                // Insert item blanko 1B ke database
                foreach ($items1B as $item) {
                    ItemBlanko::create([
                        'evaluasi_blanko_id' => $evaluasiBlanko1B->id,
                        'nama_item' => $item['nama_item'],
                        'ada_tidak_ada' => 0,
                        'bobot' => 0,
                        'kondisi' => 0,
                        'fungsi' => 0,
                        'keterangan' => '',
                    ]);
                }

                //Buat Evaluasi Blanko 1C untuk Tahapan 'Evaluasi Awal Kesiapan'
                $evaluasiBlanko1C = EvaluasiBlanko::create([
                    'tahapan_id' => $createdTahapan->id,
                    'jenis_blanko' => 'Blanko 1C',
                ]);

                // Data item blanko 1C
                $items1C = [
                    ['nama_item' => 'Bangunan Pengambilan (Bendung, Free Intake, Broncapturing)'],
                    ['nama_item' => 'Bangunan penampung air'],
                    ['nama_item' => 'Pompa dan aksesoris'],
                    ['nama_item' => 'Penggerak pompa (listrik/genset/solar cell)'],
                    ['nama_item' => 'Rumah pompa dan ruang operator'],
                    ['nama_item' => 'Rumah jaga'],
                    ['nama_item' => 'Pagar pengaman'],
                    ['nama_item' => 'Jalan masuk'],
                    ['nama_item' => 'Alat Ukur'],
                    ['nama_item' => 'Jaringan transmisi'],
                    ['nama_item' => 'Hidran Umum'],
                ];

                // Insert item blanko 1C ke database
                foreach ($items1C as $item) {
                    ItemBlanko::create([
                        'evaluasi_blanko_id' => $evaluasiBlanko1C->id,
                        'nama_item' => $item['nama_item'],
                        'ada_tidak_ada' => 0,
                        'bobot' => 0,
                        'kondisi' => 0,
                        'fungsi' => 0,
                        'keterangan' => '',
                    ]);
                }

                // Buat Evaluasi Blanko untuk Tahapan 'Blanko 2'
                $evaluasiBlanko2 = EvaluasiBlanko::create([
                    'tahapan_id' => $createdTahapan->id,
                    'jenis_blanko' => 'Blanko 2',
                ]);

                // Data item blanko 2
                 $items2 = [
                    ['nama_item' => 'Dokumen Perencanaan'],
                    ['nama_item' => 'Dokumen Pelaksanaan'],
                    ['nama_item' => 'Hasil Uji kualitas air'],
                    ['nama_item' => 'Manual OP'],
                    ['nama_item' => 'Log book, gambar dinding, Struktur organisasi P3AT/KM ATAB, gambar konstruksi sumur'],
                    ['nama_item' => 'Gambar skema tatacara operasi pompa dan penggeraknya'],
                    ['nama_item' => 'Kesanggupan melaksanakan OP'],
                    ['nama_item' => 'Daftar/data aset'],
                    ['nama_item' => 'Surat kepemilikan tanah'],
                    ['nama_item' => 'Dokumen perijinan'],
                    ['nama_item' => 'MOU/PKS/perjanjian lainnya'],
                ];

                // Insert item blanko 2 ke database
                foreach ($items2 as $item) {
                    ItemBlanko::create([
                        'evaluasi_blanko_id' => $evaluasiBlanko2->id,
                        'nama_item' => $item['nama_item'],
                        'ada_tidak_ada' => 0,
                        'bobot' => 0,
                        'kondisi' => 0,
                        'fungsi' => 0,
                        'keterangan' => '',
                    ]);
                }

                // Buat Evaluasi Blanko untuk Tahapan 'Blanko 3'
                 $evaluasiBlanko3a = EvaluasiBlanko::create([
                    'tahapan_id' => $createdTahapan->id,
                    'jenis_blanko' => 'Blanko 3A',
                ]);

                // Data item blanko 3
                 $items3A = [
                    ['nama_item' => 'Peralatan OP'],
                    ['nama_item' => 'Peralatan kantor'],
                    ['nama_item' => 'Alat komunikasi & dokumentasi'],
                    ['nama_item' => 'Transportasi'],
                    ['nama_item' => 'Kelengkapan prasarana ATAB'],
                ];

                // Insert item blanko 3A ke database
               foreach ($items3A as $item) {
                    $createdItem = ItemBlanko3::create([
                        'evaluasi_blanko_id' => $evaluasiBlanko3a->id,
                        'nama_item' => $item['nama_item'],
                    ]);

                    switch ($item['nama_item']) {
                        case 'Peralatan OP':
                            $rincianItems = [
                                'Alat-alat dasar O&P',
                                'Perlengkapan personil O&P',
                                'Peratan berat (sesuai kebutuhan)',
                            ];
                            break;
                        case 'Peralatan kantor':
                            $rincianItems = [
                                'Perabot dasar untuk kantor',
                                'Alat kerja dikantor',
                            ];
                            break;
                        case 'Alat komunikasi & dokumentasi':
                            $rincianItems = [
                                'Tilpon/HP/HT',
                                'Radio komunikasi',
                                'GPS',
                                'Camera',
                            ];
                            break;
                        case 'Transportasi':
                            $rincianItems = [
                                'Sepeda motor',
                                'Mobil pick up',
                            ];
                            break;
                        case 'Kelengkapan prasarana ATAB':
                            $rincianItems = [
                                'Nomenklatur',
                                'Peilschal',
                                'Patok batas',
                                'Papan operasi',
                                'Papan peringatan/larangan',
                            ];
                            break;
                        default:
                            $rincianItems = [];
                    }

                    foreach ($rincianItems as $rincian) {
                        ItemBlanko3Rincian::create([
                            'item_blanko3_id' => $createdItem->id,
                            'rincian' => $rincian,
                            'ada_tidak_ada' => 0,
                            'bobot' => 0,
                            'kondisi' => 0,
                            'fungsi' => 0,
                            'keterangan' => '',
                        ]);
                    }
                }

                // Buat Evaluasi Blanko untuk Tahapan 'Blanko 3B'
                $evaluasiBlanko3b = EvaluasiBlanko::create([
                    'tahapan_id' => $createdTahapan->id,
                    'jenis_blanko' => 'Blanko 3B',
                ]);

                $items3B = [
                    ['nama_item' => 'Kelembagaan OP'],
                    ['nama_item' => 'Kelembagaan kelompok masyarakat ATAB'],
                    ['nama_item' => 'Kelembagaan pengguna lainnya'],
                    ['nama_item' => 'SDM OP'],
                    ['nama_item' => 'SDM Kelompok masyarakat ATAB'],
                    ['nama_item' => 'Pelatihan OP'],
                    ['nama_item' => 'Pemberdayaan kelompok masyarakat ATAB'],
                ];

                // Insert item blanko 3B ke database
                foreach ($items3B as $item) {
                    $createdItem = ItemBlanko3::create([
                        'evaluasi_blanko_id' => $evaluasiBlanko3b->id,
                        'nama_item' => $item['nama_item'],
                    ]);

                    switch ($item['nama_item']) {
                        case 'Kelembagaan OP':
                            $rincianItems = [
                                'SK',
                                'SOTK',
                            ];
                            break;
                        case 'Kelembagaan kelompok masyarakat ATAB':
                            $rincianItems = [
                                'SK Pembentukan',
                                'AD/ART',
                                'Status Badan hukum',
                            ];
                            break;
                        case 'Kelembagaan pengguna lainnya':
                            $rincianItems = [
                                'SK Pembentukan',
                                'SOTK',
                            ];
                            break;
                        case 'SDM OP':
                            $rincianItems = [
                                'Pengamat/Koordinator Lapangan',
                                'Juru',
                                'PPA/Operator',
                            ];
                            break;
                        case 'SDM Kelompok masyarakat ATAB':
                            $rincianItems = [
                                'Ketua',
                                'Sekretaris',
                                'Bendahara',
                                'Ketua Blok',
                                'Anggota',
                            ];
                            break;
                        case 'Pelatihan OP':
                            $rincianItems = [
                                'Sosialisasi Manual OP',
                                'Pelatihan',
                            ];
                            break;
                        case 'Pemberdayaan kelompok masyarakat ATAB':
                            $rincianItems = [
                                'Aspek kelembagaan',
                                'Aspek teknis',
                                'Aspek keuangan/pembiayaan',
                            ];
                            break;
                        default:
                            $rincianItems = [];
                    }

                    foreach ($rincianItems as $rincian) {
                        ItemBlanko3Rincian::create([
                            'item_blanko3_id' => $createdItem->id,
                            'rincian' => $rincian,
                            'ada_tidak_ada' => 0,
                            'bobot' => 0,
                            'kondisi' => 0,
                            'fungsi' => 0,
                            'keterangan' => '',
                        ]);
                    }
                }

                // Buat Evaluasi Blanko untuk Tahapan 'Blanko 3C'
                $evaluasiBlanko3c = EvaluasiBlanko::create([
                    'tahapan_id' => $createdTahapan->id,
                    'jenis_blanko' => 'Blanko 3C',
                ]);

                $items3C = [
                    ['nama_item' => 'Penyesuaian Manual OP'],
                    ['nama_item' => 'Pembiayaan pada masa POP'],
                    ['nama_item' => 'Pembiayaan OP'],
                    ['nama_item' => 'Sumber pembiayaan'],
                ];

                // Insert item blanko 3C ke database
                foreach ($items3C as $item) {
                    $createdItem = ItemBlanko3::create([
                        'evaluasi_blanko_id' => $evaluasiBlanko3c->id,
                        'nama_item' => $item['nama_item'],
                    ]);

                    switch ($item['nama_item']) {
                        case 'Penyesuaian Manual OP':
                            $rincianItems = [
                                'Buku',
                                'Sosialisasi',
                            ];
                            break;
                        case 'Pembiayaan pada masa POP':
                            $rincianItems = [
                                'Operasional POP',
                                'Kelembagaan OP',
                                'Bimbingan teknis petugas OP',
                                'Kelembagaan P3AT/kelompok masyarakat ATAB',
                                'Pemberdayaan P3AT/kelompok masyarakat ATAB',
                                'Operasional pompa (BBM,olie,sparepart/perawatan) tahun ke-1 dan 2',
                                'Pemeliharaan',
                            ];
                            break;
                        case 'Pembiayaan OP':
                            $rincianItems = [
                                'Oleh Satker OP',
                                'Sharing dengan pihak lain',
                            ];
                            break;
                        case 'Sumber pembiayaan':
                            $rincianItems = [
                                'APBN',
                                'APBD',
                                'Dana Desa',
                                'BUMN/BUMD',
                                'Kelompok masyarakat ATAB',
                            ];
                            break;
                        default:
                            $rincianItems = [];
                    }

                    foreach ($rincianItems as $rincian) {
                        ItemBlanko3Rincian::create([
                            'item_blanko3_id' => $createdItem->id,
                            'rincian' => $rincian,
                            'ada_tidak_ada' => 0,
                            'bobot' => 0,
                            'kondisi' => 0,
                            'fungsi' => 0,
                            'keterangan' => '',
                        ]);
                    }
                }

                // Buat Evaluasi Blanko untuk Tahapan 'Blanko 3D'
                $evaluasiBlanko3d = EvaluasiBlanko::create([
                    'tahapan_id' => $createdTahapan->id,
                    'jenis_blanko' => 'Blanko 3D',
                ]);

                $items3D = [
                    ['nama_item' => 'Perlindungan dan pelestarian sumber air ATAB'],
                    ['nama_item' => 'Pengawetan air'],
                    ['nama_item' => 'Pengendalian dan pengelolaan kualitas air'],
                    ['nama_item' => 'Pengendalian penyemaran air'],
                ];

                // Insert item blanko 3D ke database
                foreach ($items3D as $item) {
                    $createdItem = ItemBlanko3::create([
                        'evaluasi_blanko_id' => $evaluasiBlanko3d->id,
                        'nama_item' => $item['nama_item'],
                    ]);

                    switch ($item['nama_item']) {
                        case 'Perlindungan dan pelestarian sumber air ATAB':
                            $rincianItems = [
                                'Perlindungan sumber air',
                                'Pengendalian pemanfaatan air',
                            ];
                            break;
                        case 'Pengawetan air':
                            $rincianItems = [
                                'Menyimpan air',
                                'Menghemat air',
                            ];
                            break;
                        case 'Pengendalian dan pengelolaan kualitas air':
                            $rincianItems = [
                                'Pada sumber air',
                                'Pada Prasarana SDA',
                            ];
                            break;
                        case 'Pengendalian penyemaran air':
                            $rincianItems = [
                                'Pada sumber air',
                                'Pada Prasarana SDA',
                            ];
                            break;
                        default:
                            $rincianItems = [];
                    }

                    foreach ($rincianItems as $rincian) {
                        ItemBlanko3Rincian::create([
                            'item_blanko3_id' => $createdItem->id,
                            'rincian' => $rincian,
                            'ada_tidak_ada' => 0,
                            'bobot' => 0,
                            'kondisi' => 0,
                            'fungsi' => 0,
                            'keterangan' => '',
                        ]);
                    }
                }
            }
        }
    }
}
