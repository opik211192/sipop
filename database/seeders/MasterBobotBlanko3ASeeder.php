<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterBobotBlanko3A;
use App\Models\MasterBobotBlanko3ARincian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterBobotBlanko3ASeeder extends Seeder
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
                'nama_item' => 'Peralatan OP',
                'rincian' => [
                    ['rincian' => 'Alat-alat dasar O&P', 'bobot' => 10.00],
                    ['rincian' => 'Perlengkapan personil O&P', 'bobot' => 10.00],
                    ['rincian' => 'Peratan berat (sesuai kebutuhan)', 'bobot' => 0],
                ],
            ],
            [
                'nama_item' => 'Peralatan kantor',
                'rincian' => [
                    ['rincian' => 'Perabot dasar untuk kantor', 'bobot' => 5.00],
                    ['rincian' => 'Alat kerja dikantor', 'bobot' => 5.00],
                ],
            ],
            [
                'nama_item' => 'Alat komunikasi & dokumentasi',
                'rincian' => [
                    ['rincian' => 'Tilpon/HP/HT', 'bobot' => 10.00],
                    ['rincian' => 'Radio komunikasi', 'bobot' => 0],
                    ['rincian' => 'GPS', 'bobot' => 10.00],
                    ['rincian' => 'Camera', 'bobot' => 10.00],
                ],
            ],
            [
                'nama_item' => 'Transportasi',
                'rincian' => [
                    ['rincian' => 'Sepeda motor', 'bobot' => 10.00],
                    ['rincian' => 'Mobil pick up', 'bobot' => 5.00],
                ],
            ],
            [
                'nama_item' => 'Kelengkapan prasarana ATAB',
                'rincian' => [
                    ['rincian' => 'Nomenklatur', 'bobot' => 2.00],
                    ['rincian' => 'Peilschal', 'bobot' => 10.00],
                    ['rincian' => 'Patok batas', 'bobot' => 10.00],
                    ['rincian' => 'Papan operasi', 'bobot' => 0],
                    ['rincian' => 'Papan peringatan/larangan', 'bobot' => 10],
                ],
            ],
        ];

        foreach ($items as $item) {
            $masterItem = MasterBobotBlanko3A::create(['nama_item' => $item['nama_item']]);
            foreach ($item['rincian'] as $rincian) {
                MasterBobotBlanko3ARincian::create([
                    'master_bobot_blanko_3a_id' => $masterItem->id,
                    'rincian' => $rincian['rincian'],
                    'bobot' => $rincian['bobot'],
                ]);
            }
        }
    }
}
