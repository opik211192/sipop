<?php

namespace App\Http\Controllers;

use App\Models\Jaringan;
use Illuminate\Http\Request;

class PetaJaringan extends Controller
{
    public function index()
    {
       return view('peta');
    }

    public function dataPeta()
    {
        $locations = Jaringan::select('nama', 'latitude', 'longitude', 'jenis')->distinct()->get();

        return response()->json($locations);
    }
}
