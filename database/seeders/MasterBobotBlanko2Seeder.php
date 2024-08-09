<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterBobotBlanko2;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MasterBobotBlanko2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $items = [
            ['nama_item' => 'Dokumen Perencanaan', 'bobot' => 15.00],
            ['nama_item' => 'Kontrak', 'bobot' => 15.00],
            ['nama_item' => 'AS Build Drawing', 'bobot' => 10.00],
            ['nama_item' => 'PHO', 'bobot' => 10.00],
            ['nama_item' => 'Dokumentasi', 'bobot' => 10.00],
            ['nama_item' => 'Hasil Uji kualitas air', 'bobot' => 0],
            ['nama_item' => 'Manual OP', 'bobot' => 10.00],
            ['nama_item' => 'Log book', 'bobot' => 0],
            ['nama_item' => 'Gambar dinding', 'bobot' => 10.00],
            ['nama_item' => 'Struktur organisasi P3AT/KM ATAB', 'bobot' => 0],
            ['nama_item' => 'Gambar konstruksi sumur', 'bobot' => 10],
            ['nama_item' => 'Gambar skema tatacara operasi pompa dan penggeraknya', 'bobot' => 0],
            ['nama_item' => 'Kesanggupan melaksanakan OP', 'bobot' => 0],
            ['nama_item' => 'Daftar/data aset', 'bobot' => 0],
            ['nama_item' => 'Surat kepemilikan tanah', 'bobot' => 10.00],
            ['nama_item' => 'Dokumen perijinan', 'bobot' => 0],
            ['nama_item' => 'MOU/PKS/perjanjian lainnya', 'bobot' => 0],
        ];

        foreach ($items as $item) {
            MasterBobotBlanko2::create($item);
        }
    }
}
