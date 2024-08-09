<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterBobotBlanko3C;
use App\Models\MasterBobotBlanko3CRincian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterBobotBlanko3CSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'nama_item' => 'Penyesuaian Manual OP',
                'rincian' => [
                    ['rincian' => 'Buku', 'bobot' => 12.50],
                    ['rincian' => 'Sosialisasi', 'bobot' => 12.50],
                ],
            ],
            [
                'nama_item' => 'Pembiayaan pada masa POP',
                'rincian' => [
                    ['rincian' => 'Operasional POP', 'bobot' => 12.50],
                    ['rincian' => 'Kelembagaan OP', 'bobot' => 12.50],
                    ['rincian' => 'Bimbingan teknis petugas OP', 'bobot' => 12.50],
                    ['rincian' => 'Kelembagaan P3AT/kelompok masyarakat ATAB', 'bobot' => 0],
                    ['rincian' => 'Pemberdayaan P3AT/kelompok masyarakat ATAB', 'bobot' => 0],
                    ['rincian' => 'Operasional pompa (BBM,olie,sparepart/perawatan) tahun ke-1 dan 2', 'bobot' => 0],
                    ['rincian' => 'Pemeliharaan', 'bobot' => 12.50],
                ],
            ],
            [
                'nama_item' => 'Pembiayaan OP',
                'rincian' => [
                    ['rincian' => 'Oleh Satker OP', 'bobot' => 12.50],
                    ['rincian' => 'Sharing dengan pihak lain', 'bobot' => 0],
                ],
            ],
            [
                'nama_item' => 'Sumber pembiayaan',
                'rincian' => [
                    ['rincian' => 'APBN', 'bobot' => 12.50],
                    ['rincian' => 'APBD', 'bobot' => 0],
                    ['rincian' => 'Dana Desa', 'bobot' => 0],
                    ['rincian' => 'BUMN/BUMD', 'bobot' => 0],
                    ['rincian' => 'Kelompok masyarakat ATAB', 'bobot' => 0],
                ],
            ],
        ];

        foreach ($items as $item) {
            $masterItem = MasterBobotBlanko3C::create(['nama_item' => $item['nama_item']]);
            foreach ($item['rincian'] as $rincian) {
                MasterBobotBlanko3CRincian::create([
                    'master_bobot_blanko_3c_id' => $masterItem->id,
                    'rincian' => $rincian['rincian'],
                    'bobot' => $rincian['bobot'],
                ]);
            }
        }
    }
}
