<?php

namespace App\Http\Controllers\Api;

use App\Models\Jaringan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\JaringanResource;

class JaringanController extends Controller
{
    public function index()
    {
        $jaringans = Jaringan::with(['province', 'city', 'district', 'village'])->paginate(10);

        if ($jaringans->isEmpty()) {
            return response()->json([
                'data' => []
            ]);
        }

        return JaringanResource::collection($jaringans);
    }

    
    public function show($id)
    {
        $jaringan = Jaringan::with(['province', 'city', 'district', 'village'])->findOrFail($id);


        return new JaringanResource($jaringan);
    }

    
    public function tahapan()
    {
        $tahapan = [
            'Persiapan',
            'Pembentukan Tim',
            'Penyusunan Rencana Kerja',
            'Sosialisasi dan Koordinasi',
            'Penyusunan Lembar Evaluasi Kesiapan OP',
            'Inventarisasi Data dan Informasi',
            'Evaluasi Awal Kesiapan OP',
            'Evaluasi Akhir Kesiapan OP',
            'Serah Terima hasil OP'
        ];

        return response()->json([
            'data' => $tahapan
        ]);
    }


    public function filterTahun($tahun)
    {
        $jaringans = Jaringan::with(['province', 'city', 'district', 'village'])
            ->where('tahun', $tahun)
            ->paginate(10);

        if ($jaringans->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan.',
            ], 404);
        }

        return JaringanResource::collection($jaringans);
    }
}

