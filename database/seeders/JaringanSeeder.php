<?php

namespace Database\Seeders;

use App\Models\jaringan;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JaringanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Jaringan::create([
            'nama' => 'Hanum',
            'latitude' => -7.235007,
            'longitude' => 108.6102753,
            'province_id' => 12,
            'city_id' => 187,
            'district_id' => 2618,
            'village_id' => 31754,
            'wilayah_sungai' => 'sungai citanduy',
            'jenis' => 'Air Tanah',
            'tahun' => 2015,
            'satker' => 'Satker PJPA',
            'tahapan' => NULL,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Jaringan::create([
            'nama' => 'Kedungreja',
            'latitude' => -7.5117887,
            'longitude' => 108.6838908,
            'province_id' => 12,
            'city_id' => 187,
            'district_id' => 2616,
            'village_id' => 31741,
            'wilayah_sungai' => 'sungai citanduy',
            'jenis' => 'Air Baku',
            'tahun' => 2015,
            'satker' => 'Satker PJPA',
            'tahapan' => NULL,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Jaringan::create([
            'nama' => 'Tambaksari',
            'latitude' => -7.236178,
            'longitude' => 108.0710819,
            'province_id' => 12,
            'city_id' => 186,
            'district_id' => 2612,
            'village_id' => 31709,
            'wilayah_sungai' => 'sungai citanduy',
            'jenis' => 'Embung',
            'tahun' => 2015,
            'satker' => 'Satker PJPA',
            'tahapan' => NULL,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
    }
}
