<?php

namespace Database\Seeders;

use App\Models\jaringan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class JaringanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // jaringan::create([
        //     'nama' => 'Jaringan 1',
        //     'latitude' => '-6.17511',
        //     'longitude' => '106.8272',
        //     'province_id' => 13,
        //     'city_id' => 188,
        //     'district_id' => 2634,
        //     'village_id' => 31818,
        //     'wilayah_sungai' => 'Sungai Citanduy',
        //     'jenis' => 'Irigasi',
        //     'tahun' => '2014',
        //     'satker' => 'Satker PJPA',
        //     'tahapan' => ''
        // ]);

        $faker = Faker::create();

        for ($i = 1; $i <= 50; $i++) {
            Jaringan::create([
                'nama' => 'Jaringan ' . $i,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
                'province_id' => 1, // Sesuaikan dengan jumlah provinsi yang ada
                'city_id' =>  1, // Sesuaikan dengan jumlah kota yang ada
                'district_id' => 1, // Sesuaikan dengan jumlah kecamatan yang ada
                'village_id' => 1, // Sesuaikan dengan jumlah desa yang ada
                'wilayah_sungai' => $faker->word,
                'jenis' => $faker->randomElement(['Irigasi', 'Embung', 'ATAB']),
                'tahun' => $faker->year,
                'satker' => $faker->randomElement(['Satker Balai', 'Satker PJPA', 'Satker PJSA', 'Satker Bendungan']),
                'tahapan' => $faker->word,
            ]);
        }
    }
}
