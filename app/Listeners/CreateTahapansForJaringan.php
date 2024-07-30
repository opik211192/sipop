<?php

namespace App\Listeners;

use App\Models\Jaringan;
use App\Models\Tahapan;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateTahapansForJaringan
{
    /**
     * Handle the event.
     *
     * @param  \App\Models\Jaringan  $jaringan
     * @return void
     */
    public function handle(Jaringan $jaringan)
    {
        $tahapans = [
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Pembentukan Tim', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Penyusunan Rencana Kerja', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Sosialisasi dan Koordinasi', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Evaluasi Awal Kesiapan', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Upload Dokumen Utama', 'nilai' => null],
        ];

        Tahapan::insert($tahapans);
    }
}
