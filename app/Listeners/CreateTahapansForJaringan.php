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

            // Buat Evaluasi Blanko berdasarkan jenis jaringan
            if ($createdTahapan->nama_tahapan === 'Evaluasi Awal Kesiapan') {
                if ($jaringan->jenis === 'Air Tanah') {
                    $this->createBlanko1A($createdTahapan->id);
                    $this->createBlanko1B($createdTahapan->id);
                }
                
                if ($jaringan->jenis === 'Air Baku' || $jaringan->jenis === 'Embung') {
                    $this->createBlanko1C($createdTahapan->id);
                }

                // Blanko yang umum untuk semua jenis jaringan
                $this->createBlanko2($createdTahapan->id);
                $this->createBlanko3A($createdTahapan->id);
                $this->createBlanko3B($createdTahapan->id);
                $this->createBlanko3C($createdTahapan->id);
                $this->createBlanko3D($createdTahapan->id);
            }
        }
    }

    private function createBlanko1A($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 1A',
        ]);

        $items = [
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

        foreach ($items as $item) {
            ItemBlanko::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
                'nama_item' => $item['nama_item'],
                'ada_tidak_ada' => 0,
                'bobot' => 0,
                'kondisi' => 0,
                'fungsi' => 0,
                'keterangan' => '',
            ]);
        }
    }

    private function createBlanko1B($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 1B',
        ]);

        $items = [
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

        foreach ($items as $item) {
            ItemBlanko::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
                'nama_item' => $item['nama_item'],
                'ada_tidak_ada' => 0,
                'bobot' => 0,
                'kondisi' => 0,
                'fungsi' => 0,
                'keterangan' => '',
            ]);
        }
    }

    private function createBlanko1C($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 1C',
        ]);

        $items = [
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

        foreach ($items as $item) {
            ItemBlanko::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
                'nama_item' => $item['nama_item'],
                'ada_tidak_ada' => 0,
                'bobot' => 0,
                'kondisi' => 0,
                'fungsi' => 0,
                'keterangan' => '',
            ]);
        }
    }

    private function createBlanko2($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 2',
        ]);

        $items = [
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

        foreach ($items as $item) {
            ItemBlanko::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
                'nama_item' => $item['nama_item'],
                'ada_tidak_ada' => 0,
                'bobot' => 0,
                'kondisi' => 0,
                'fungsi' => 0,
                'keterangan' => '',
            ]);
        }
    }

    private function createBlanko3A($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 3A',
        ]);

        $items = [
            ['nama_item' => 'Peralatan OP'],
            ['nama_item' => 'Peralatan kantor'],
            ['nama_item' => 'Alat komunikasi & dokumentasi'],
            ['nama_item' => 'Transportasi'],
            ['nama_item' => 'Kelengkapan prasarana ATAB'],
        ];

        foreach ($items as $item) {
            $createdItem = ItemBlanko3::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
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
    }

    private function createBlanko3B($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 3B',
        ]);

        $items = [
            ['nama_item' => 'Kelembagaan OP'],
            ['nama_item' => 'Kelembagaan kelompok masyarakat ATAB'],
            ['nama_item' => 'Kelembagaan pengguna lainnya'],
            ['nama_item' => 'SDM OP'],
            ['nama_item' => 'SDM Kelompok masyarakat ATAB'],
            ['nama_item' => 'Pelatihan OP'],
            ['nama_item' => 'Pemberdayaan kelompok masyarakat ATAB'],
        ];

        foreach ($items as $item) {
            $createdItem = ItemBlanko3::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
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
    }

    private function createBlanko3C($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 3C',
        ]);

        $items = [
            ['nama_item' => 'Penyesuaian Manual OP'],
            ['nama_item' => 'Pembiayaan pada masa POP'],
            ['nama_item' => 'Pembiayaan OP'],
            ['nama_item' => 'Sumber pembiayaan'],
        ];

        foreach ($items as $item) {
            $createdItem = ItemBlanko3::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
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
    }

    private function createBlanko3D($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 3D',
        ]);

        $items = [
            ['nama_item' => 'Perlindungan dan pelestarian sumber air ATAB'],
            ['nama_item' => 'Pengawetan air'],
            ['nama_item' => 'Pengendalian dan pengelolaan kualitas air'],
            ['nama_item' => 'Pengendalian penyemaran air'],
        ];

        foreach ($items as $item) {
            $createdItem = ItemBlanko3::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
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
