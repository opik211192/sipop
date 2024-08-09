<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterBobotBlanko3D;
use App\Models\MasterBobotBlanko3DRincian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterBobotBlanko3DSeeder extends Seeder
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
                'nama_item' => 'Perlindungan dan pelestarian sumber air ATAB',
                'rincian' => [
                    ['rincian' => 'Perlindungan sumber air', 'bobot' => 25.00],
                    ['rincian' => 'Pengendalian pemanfaatan air', 'bobot' => 25.00],
                ],
            ],
            [
                'nama_item' => 'Pengawetan air',
                'rincian' => [
                    ['rincian' => 'Menyimpan air', 'bobot' => 25.00],
                    ['rincian' => 'Menghemat air', 'bobot' => 25.00],
                ],
            ],
            [
                'nama_item' => 'Pengendalian dan pengelolaan kualitas air',
                'rincian' => [
                    ['rincian' => 'Pada sumber air', 'bobot' => 0],
                    ['rincian' => 'Pada Prasarana SDA', 'bobot' => 0],
                ],
            ],
            [
                'nama_item' => 'Pengendalian penyemaran air',
                'rincian' => [
                    ['rincian' => 'Pada sumber air', 'bobot' => 0],
                    ['rincian' => 'Pada Prasarana SDA', 'bobot' => 0],
                ],
            ],
        ];

        foreach ($items as $item) {
            $masterItem = MasterBobotBlanko3D::create(['nama_item' => $item['nama_item']]);
            foreach ($item['rincian'] as $rincian) {
                MasterBobotBlanko3DRincian::create([
                    'master_bobot_blanko_3d_id' => $masterItem->id,
                    'rincian' => $rincian['rincian'],
                    'bobot' => $rincian['bobot'],
                ]);
            }
        }
    }
}
