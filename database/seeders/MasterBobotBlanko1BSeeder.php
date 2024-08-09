<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterBobotBlanko1B;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterBobotBlanko1BSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['nama_item' => 'Mesin bor dan kendaraan pengangkutnya', 'bobot' => 0],
            ['nama_item' => 'Kompresor', 'bobot' => 0],
            ['nama_item' => 'Genset', 'bobot' => 0],
            ['nama_item' => 'Mesin las', 'bobot' => 0],
            ['nama_item' => 'Truk Crane', 'bobot' => 0],
            ['nama_item' => 'Mobil Water Tank', 'bobot' => 0],
            ['nama_item' => 'Pompa Air', 'bobot' => 100],
            ['nama_item' => 'Pompa lumpur', 'bobot' => 0],
            ['nama_item' => 'Set mata bor', 'bobot' => 0],
            ['nama_item' => 'Mixer bentonait', 'bobot' => 0],
            ['nama_item' => 'Peralatan Logging', 'bobot' => 0],
        ];

        foreach ($items as $item) {
            MasterBobotBlanko1B::create($item);
        }
    }
}
