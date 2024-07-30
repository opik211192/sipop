<?php

namespace App\Http\Controllers;

use App\Models\Jaringan;
use Illuminate\Http\Request;

class EvaluasiController extends Controller
{
    public function evaluasiAwal(Jaringan $jaringan)
    {
        return view('evaluasi.evaluasi_awal', compact('jaringan'));
    }
}
