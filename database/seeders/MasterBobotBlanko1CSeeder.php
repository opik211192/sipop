<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterBobotBlanko1C;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterBobotBlanko1CSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['nama_item' => 'Bangunan Pengambilan (Bendung, Free Intake, Broncapturing)', 'bobot' => 20.00],
            ['nama_item' => 'Bangunan penampung air', 'bobot' => 20.00],
            ['nama_item' => 'Pompa dan aksesoris', 'bobot' => 0],
            ['nama_item' => 'Penggerak pompa (listrik/genset/solar cell)', 'bobot' => 0],
            ['nama_item' => 'Rumah pompa dan ruang operator', 'bobot' => 0],
            ['nama_item' => 'Rumah jaga', 'bobot' => 0],
            ['nama_item' => 'Pagar pengaman', 'bobot' => 15.00],
            ['nama_item' => 'Jalan masuk', 'bobot' => 10.00],
            ['nama_item' => 'Alat Ukur', 'bobot' => 10.00],
            ['nama_item' => 'Jaringan transmisi', 'bobot' => 10.00],
            ['nama_item' => 'Hidran Umum', 'bobot' => 15.00],
        ];

        foreach ($items as $item) {
            MasterBobotBlanko1C::create($item);
        }
    }
}
