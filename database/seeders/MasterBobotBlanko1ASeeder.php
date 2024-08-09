<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterBobotBlanko1A;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterBobotBlanko1ASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['nama_item' => 'Sumur', 'bobot' => 10.00],
            ['nama_item' => 'Pompa dan aksesoris', 'bobot' => 15.00],
            ['nama_item' => 'Penggerak Pompa (Listrik/Genset/Solar Cell)', 'bobot' => 15.00],
            ['nama_item' => 'Rumah Pompa', 'bobot' => 10.00],
            ['nama_item' => 'Jaringan air tanah', 'bobot' => 15.00],
            ['nama_item' => 'Rumah jaga', 'bobot' => 0],
            ['nama_item' => 'Pagar pengaman', 'bobot' => 10.00],
            ['nama_item' => 'Jalan masuk', 'bobot' => 5.00],
            ['nama_item' => 'Alat ukur', 'bobot' => 5.00],
            ['nama_item' => 'Hidran umum', 'bobot' => 10.00],
            ['nama_item' => 'Reservoir', 'bobot' => 5.00],
        ];

          foreach ($items as $item) {
            MasterBobotBlanko1A::create($item);
        }
    }
}
