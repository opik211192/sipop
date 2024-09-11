<?php

namespace App\Http\Controllers;

use App\Models\Jaringan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $currentYear = date('Y');
        $years = range(1990, $currentYear);

        $defaultYear = $currentYear - 1;
        $selectedYear = $request->input('tahun', $defaultYear);
        $selectedSatker = $request->input('satker', 'PJPA');

        $query = Jaringan::where('tahun', $selectedYear);
        if ($selectedSatker == 'PJPA') {
            $query->whereIn('jenis', ['Air Tanah', 'Air Baku', 'Embung']);
        } elseif ($selectedSatker == 'PJSA') {
            $query->whereIn('jenis', ['Air Tanah', 'Air Baku']);
        } elseif ($selectedSatker == 'Bendungan') {
            $query->where('jenis', 'Embung');
        }

        $totalJaringan = $query->count();
        $totalAirTanah = $query->clone()->where('jenis', 'Air Tanah')->count();
        $totalAirBaku = $query->clone()->where('jenis', 'Air Baku')->count();
        $totalEmbung = $query->clone()->where('jenis', 'Embung')->count();

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

        $jaringans = $query->orderBy('id')->get();

        $labels = [];
        $data = [];
        $colors = [];
        $borderColors = [];
        $percentages = [];
        $jaringanIds = [];

        foreach ($jaringans as $jaringan) {
            $labels[] = $jaringan->nama . ' (' . $jaringan->jenis . ')';
            $index = $jaringan->tahapan ? array_search($jaringan->tahapan, $tahapan) : 0;
            $data[] = $index;

            // Hitung persentase kemajuan
            $percentage = ($index / (count($tahapan) - 1)) * 100;
            $percentages[] = round($percentage);

            // Masukkan ID jaringan ke dalam array
            $jaringanIds[] = $jaringan->id;

            if ($jaringan->jenis == 'Air Tanah') {
                $colors[] = 'rgba(0, 123, 255, 0.7)';
                $borderColors[] = 'rgba(0, 123, 255, 1)';
            } elseif ($jaringan->jenis == 'Air Baku') {
                $colors[] = 'rgba(255, 193, 7, 0.7)';
                $borderColors[] = 'rgba(255, 193, 7, 1)';
            } elseif ($jaringan->jenis == 'Embung') {
                $colors[] = 'rgba(40, 167, 69, 0.7)';
                $borderColors[] = 'rgba(40, 167, 69, 1)';
            } else {
                $colors[] = 'rgba(153, 102, 255, 0.7)';
                $borderColors[] = 'rgba(153, 102, 255, 1)';
            }
        }

        return view('home', compact(
            'totalJaringan',
            'totalAirTanah',
            'totalAirBaku',
            'totalEmbung',
            'tahapan',
            'labels',
            'data',
            'colors',
            'borderColors',
            'percentages', // Tambahkan persentase ke view
            'jaringanIds',
            'years',
            'selectedYear',
            'selectedSatker'
        ));
    }
}
