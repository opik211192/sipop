<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterBobotBlanko3B;
use App\Models\MasterBobotBlanko3BRincian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterBobotBlanko3BSeeder extends Seeder
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
                'nama_item' => 'Kelembagaan OP',
                'rincian' => [
                    ['rincian' => 'SK', 'bobot' => 20.00],
                    ['rincian' => 'SOTK', 'bobot' => 0],
                ],
            ],
            [
                'nama_item' => 'Kelembagaan kelompok masyarakat ATAB',
                'rincian' => [
                    ['rincian' => 'SK Pembentukan', 'bobot' => 0],
                    ['rincian' => 'AD/ART', 'bobot' => 0],
                    ['rincian' => 'Status Badan hukum', 'bobot' => 0],
                ],
            ],
            [
                'nama_item' => 'Kelembagaan pengguna lainnya',
                'rincian' => [
                    ['rincian' => 'SK Pembentukan', 'bobot' => 0],
                    ['rincian' => 'SOTK', 'bobot' => 0],
                ],
            ],
            [
                'nama_item' => 'SDM OP',
                'rincian' => [
                    ['rincian' => 'Pengamat/Koordinator Lapangan', 'bobot' => 15.00],
                    ['rincian' => 'Juru', 'bobot' => 15.00],
                    ['rincian' => 'PPA/Operator', 'bobot' => 15.00],
                ],
            ],
            [
                'nama_item' => 'SDM Kelompok masyarakat ATAB',
                'rincian' => [
                    ['rincian' => 'Ketua', 'bobot' => 0],
                    ['rincian' => 'Sekretaris', 'bobot' => 0],
                    ['rincian' => 'Bendahara', 'bobot' => 0],
                    ['rincian' => 'Ketua Blok', 'bobot' => 0],
                    ['rincian' => 'Anggota', 'bobot' => 0],
                ],
            ],
            [
                'nama_item' => 'Pelatihan OP',
                'rincian' => [
                    ['rincian' => 'Sosialisasi Manual OP', 'bobot' => 20.00],
                    ['rincian' => 'Pelatihan', 'bobot' => 15],
                ],
            ],
            [
                'nama_item' => 'Pemberdayaan kelompok masyarakat ATAB',
                'rincian' => [
                    ['rincian' => 'Aspek kelembagaan', 'bobot' => 0],
                    ['rincian' => 'Aspek teknis', 'bobot' => 0],
                    ['rincian' => 'Aspek keuangan/pembiayaan', 'bobot' => 0],
                ],
            ],
        ];

        foreach ($items as $item) {
            $masterItem = MasterBobotBlanko3B::create(['nama_item' => $item['nama_item']]);
            foreach ($item['rincian'] as $rincian) {
                MasterBobotBlanko3BRincian::create([
                    'master_bobot_blanko_3b_id' => $masterItem->id,
                    'rincian' => $rincian['rincian'],
                    'bobot' => $rincian['bobot'],
                ]);
            }
        }
    }
}
