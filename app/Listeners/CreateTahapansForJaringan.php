<?php

namespace App\Listeners;

use App\Models\Jaringan;
use App\Models\Tahapan;
use App\Models\EvaluasiBlanko;
use App\Models\ItemBlanko;
use App\Models\ItemBlanko3;
use App\Models\ItemBlanko3Rincian;
use App\Models\MasterBobotBlanko1A;
use App\Models\MasterBobotBlanko1B;
use App\Models\MasterBobotBlanko1C;
use App\Models\MasterBobotBlanko2;
use App\Models\MasterBobotBlanko3A;
use App\Models\MasterBobotBlanko3ARincian;
use App\Models\MasterBobotBlanko3B;
use App\Models\MasterBobotBlanko3BRincian;
use App\Models\MasterBobotBlanko3C;
use App\Models\MasterBobotBlanko3CRincian;
use App\Models\MasterBobotBlanko3D;
use App\Models\MasterBobotBlanko3DRincian;

class CreateTahapansForJaringan
{
    public function handle(Jaringan $jaringan)
    {
        $tahapans = [
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Pembentukan Tim', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Penyusunan Rencana Kerja', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Sosialisasi dan Koordinasi', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Evaluasi Awal Kesiapan', 'nilai' => null],
            //['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Upload Dokumen Utama', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'BA Hasil Evaluasi Awal Kesiapan OP', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Evaluasi Akhir Kesiapan', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'BA Hasil Evaluasi Akhir Kesiapan OP', 'nilai' => null],
            ['jaringan_id' => $jaringan->id, 'nama_tahapan' => 'Serah Terima hasil OP', 'nilai' => null],

        ];

        foreach ($tahapans as $tahapan) {
            $createdTahapan = Tahapan::create($tahapan);

            if ($createdTahapan->nama_tahapan === 'Evaluasi Awal Kesiapan') {
                if ($jaringan->jenis === 'Air Tanah') {
                    $this->createBlanko1A($createdTahapan->id);
                    $this->createBlanko1B($createdTahapan->id);
                } elseif ($jaringan->jenis === 'Air Baku' || $jaringan->jenis === 'Embung') {
                    $this->createBlanko1C($createdTahapan->id);
                }

                $this->createBlanko2($createdTahapan->id);
                $this->createBlanko3A($createdTahapan->id);
                $this->createBlanko3B($createdTahapan->id);
                $this->createBlanko3C($createdTahapan->id);
                $this->createBlanko3D($createdTahapan->id);
            }
        }
    }

    private function createBlanko1A($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 1A',
        ]);

        $masterItems = MasterBobotBlanko1A::all();

        foreach ($masterItems as $masterItem) {
            ItemBlanko::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
                'nama_item' => $masterItem->nama_item,
                'bobot' => $masterItem->bobot,
                'ada_tidak_ada' => 0,
                'kondisi' => 0,
                'fungsi' => 0,
                'keterangan' => '',
            ]);
        }
    }

    private function createBlanko1B($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 1B',
        ]);

        $masterItems = MasterBobotBlanko1B::all();

        foreach ($masterItems as $masterItem) {
            ItemBlanko::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
                'nama_item' => $masterItem->nama_item,
                'bobot' => $masterItem->bobot,
                'ada_tidak_ada' => 0,
                'kondisi' => 0,
                'fungsi' => 0,
                'keterangan' => '',
            ]);
        }
    }

    private function createBlanko1C($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 1C',
        ]);

        $masterItems = MasterBobotBlanko1C::all();

        foreach ($masterItems as $masterItem) {
            ItemBlanko::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
                'nama_item' => $masterItem->nama_item,
                'bobot' => $masterItem->bobot,
                'ada_tidak_ada' => 0,
                'kondisi' => 0,
                'fungsi' => 0,
                'keterangan' => '',
            ]);
        }
    }

    private function createBlanko2($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 2',
        ]);

        $masterItems = MasterBobotBlanko2::all();

        foreach ($masterItems as $masterItem) {
            ItemBlanko::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
                'nama_item' => $masterItem->nama_item,
                'bobot' => $masterItem->bobot,
                'ada_tidak_ada' => 0,
                'kondisi' => 0,
                'fungsi' => 0,
                'keterangan' => '',
            ]);
        }
    }

    private function createBlanko3A($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 3A',
        ]);

        $masterItems = MasterBobotBlanko3A::with('rincian')->get();

        foreach ($masterItems as $masterItem) {
            $createdItem = ItemBlanko3::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
                'nama_item' => $masterItem->nama_item,
            ]);

            foreach ($masterItem->rincian as $rincian) {
                ItemBlanko3Rincian::create([
                    'item_blanko3_id' => $createdItem->id,
                    'rincian' => $rincian->rincian,
                    'bobot' => $rincian->bobot,
                    'ada_tidak_ada' => 0,
                    'kondisi' => 0,
                    'fungsi' => 0,
                    'keterangan' => '',
                ]);
            }
        }
    }

    private function createBlanko3B($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 3B',
        ]);

        $masterItems = MasterBobotBlanko3B::with('rincian')->get();

        foreach ($masterItems as $masterItem) {
            $createdItem = ItemBlanko3::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
                'nama_item' => $masterItem->nama_item,
            ]);

            foreach ($masterItem->rincian as $rincian) {
                ItemBlanko3Rincian::create([
                    'item_blanko3_id' => $createdItem->id,
                    'rincian' => $rincian->rincian,
                    'bobot' => $rincian->bobot,
                    'ada_tidak_ada' => 0,
                    'kondisi' => 0,
                    'fungsi' => 0,
                    'keterangan' => '',
                ]);
            }
        }
    }

    private function createBlanko3C($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 3C',
        ]);

        $masterItems = MasterBobotBlanko3C::with('rincian')->get();

        foreach ($masterItems as $masterItem) {
            $createdItem = ItemBlanko3::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
                'nama_item' => $masterItem->nama_item,
            ]);

            foreach ($masterItem->rincian as $rincian) {
                ItemBlanko3Rincian::create([
                    'item_blanko3_id' => $createdItem->id,
                    'rincian' => $rincian->rincian,
                    'bobot' => $rincian->bobot,
                    'ada_tidak_ada' => 0,
                    'kondisi' => 0,
                    'fungsi' => 0,
                    'keterangan' => '',
                ]);
            }
        }
    }

    private function createBlanko3D($tahapanId)
    {
        $evaluasiBlanko = EvaluasiBlanko::create([
            'tahapan_id' => $tahapanId,
            'jenis_blanko' => 'Blanko 3D',
        ]);

        $masterItems = MasterBobotBlanko3D::with('rincian')->get();

        foreach ($masterItems as $masterItem) {
            $createdItem = ItemBlanko3::create([
                'evaluasi_blanko_id' => $evaluasiBlanko->id,
                'nama_item' => $masterItem->nama_item,
            ]);

            foreach ($masterItem->rincian as $rincian) {
                ItemBlanko3Rincian::create([
                    'item_blanko3_id' => $createdItem->id,
                    'rincian' => $rincian->rincian,
                    'bobot' => $rincian->bobot,
                    'ada_tidak_ada' => 0,
                    'kondisi' => 0,
                    'fungsi' => 0,
                    'keterangan' => '',
                ]);
            }
        }
    }
}
