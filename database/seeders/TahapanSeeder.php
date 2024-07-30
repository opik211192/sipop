<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $jaringanId = 1; // Sesuaikan dengan ID jaringan yang sesuai

        $tahapans = [
            ['jaringan_id' => $jaringanId, 'nama_tahapan' => 'Pembentukan Tim', 'nilai' => null],
            ['jaringan_id' => $jaringanId, 'nama_tahapan' => 'Penyusunan Rencana Kerja', 'nilai' => null],
            ['jaringan_id' => $jaringanId, 'nama_tahapan' => 'Sosialisasi dan Koordinasi', 'nilai' => null],
            ['jaringan_id' => $jaringanId, 'nama_tahapan' => 'Evaluasi Awal Kesiapan', 'nilai' => null],
            ['jaringan_id' => $jaringanId, 'nama_tahapan' => 'Upload Dokumen Utama', 'nilai' => null],
        ];

        DB::table('tahapans')->insert($tahapans);
    }
}
