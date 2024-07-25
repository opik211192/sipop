<?php

namespace Database\Seeders;

use App\Models\jaringan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JaringanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        jaringan::create([
            'nama' => 'Jaringan 1',
            'latitude' => '-6.17511',
            'longitude' => '106.8272',
            'province_id' => 13,
            'city_id' => 188,
            'district_id' => 2634,
            'village_id' => 31818,
            'tahapan' => ''
        ]);
    }
}
