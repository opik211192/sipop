<?php

namespace App\Http\Controllers;

use App\Models\Jaringan;
use Illuminate\Http\Request;
use App\Models\Blanko2Upload;

class LihatDokumenController extends Controller
{
    public function kontrak(Jaringan $jaringan)
    {
        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
        $evaluasiBlanko = $tahapan ? $tahapan->evaluasiBlankos()->where('jenis_blanko', 'Blanko 2')->first() : null;

        $fileUrl = null;
        if ($evaluasiBlanko) {
            $itemBlanko = $evaluasiBlanko->items()->where('nama_item', 'Kontrak')->first();
            if ($itemBlanko) {
                $file = Blanko2Upload::where('item_blanko_id', $itemBlanko->id)->first();
                if ($file) {
                    $fileUrl = asset('storage/blanko2/' . $file->nama_file);
                }
            }
        }

        if ($fileUrl) {
            return view('your-view', compact('fileUrl')); // Pass the URL to your view
        }

        return redirect()->back()->with('error', 'Dokumen Kontrak tidak ditemukan.');
    }


    public function asBuildDrawing()
    {

    }

    public function pho()
    {

    }

    public function manualOP()
    {

    }

    public function dokuemntasi()
    {

    }
}
