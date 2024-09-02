<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\JabatanDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat Jabatan
        $satkerId = Jabatan::create([
            'nama_jabatan' => 'Satker'
        ])->id;

        $ppkId = Jabatan::create([
            'nama_jabatan' => 'PPK'
        ])->id;

        // Membuat JabatanDetail
        JabatanDetail::create([
            'jabatan_id' => $satkerId,
            'nama_jabatan_detail' => 'Satker Balai'
        ]);

        JabatanDetail::create([
            'jabatan_id' => $satkerId,
            'nama_jabatan_detail' => 'Satker PJSA'
        ]);

        JabatanDetail::create([
            'jabatan_id' => $satkerId,
            'nama_jabatan_detail' => 'Satker PJPA'
        ]);

        JabatanDetail::create([
            'jabatan_id' => $satkerId,
            'nama_jabatan_detail' => 'Satker Bendungan'
        ]);

        JabatanDetail::create([
            'jabatan_id' => $satkerId,
            'nama_jabatan_detail' => 'Satker OP'
        ]);
        
        JabatanDetail::create([
            'jabatan_id' => $ppkId,
            'nama_jabatan_detail' => 'PPK Air Tanah dan Air Baku'
        ]);

        JabatanDetail::create([
            'jabatan_id' => $ppkId,
            'nama_jabatan_detail' => 'PPK Bendungan'
        ]);

        JabatanDetail::create([
            'jabatan_id' => $ppkId,
            'nama_jabatan_detail' => 'PPK Perencanaan Bendungan'
        ]);

        JabatanDetail::create([
            'jabatan_id' => $ppkId,
            'nama_jabatan_detail' => 'PPK Perencanaan dan Program'
        ]);

        JabatanDetail::create([
            'jabatan_id' => $ppkId,
            'nama_jabatan_detail' => 'PPK PSDA'
        ]);
    }
}
