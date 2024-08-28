<?php

namespace App\Http\Controllers;

use App\Models\Jaringan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
  public function index(Request $request)
{
    // Menghasilkan daftar tahun dari 1990 hingga tahun saat ini
    $currentYear = date('Y');
    $years = range(1990, $currentYear);

    // Tahun default adalah tahun sekarang - 1
    $defaultYear = $currentYear - 1;

    // Tahun yang dipilih oleh pengguna, atau default jika tidak ada yang dipilih
    $selectedYear = $request->input('tahun', $defaultYear);

    // Satker yang dipilih oleh pengguna, default ke 'PJPA'
    $selectedSatker = $request->input('satker', 'PJPA');

    // Filter berdasarkan Satker yang dipilih
    $query = Jaringan::where('tahun', $selectedYear);
    if ($selectedSatker == 'PJPA') {
        $query->whereIn('jenis', ['Air Tanah', 'Air Baku', 'Embung']);
    } elseif ($selectedSatker == 'PJSA') {
        $query->whereIn('jenis', ['Air Tanah', 'Air Baku']);
    } elseif ($selectedSatker == 'Bendungan') {
        $query->where('jenis', 'Embung');
    }

    // Menghitung total jaringan berdasarkan tahun dan satker yang dipilih
    $totalJaringan = $query->count();

    // Menghitung total untuk setiap jenis jaringan berdasarkan tahun dan satker yang dipilih
    $totalAirTanah = $query->clone()->where('jenis', 'Air Tanah')->count();
    $totalAirBaku = $query->clone()->where('jenis', 'Air Baku')->count();
    $totalEmbung = $query->clone()->where('jenis', 'Embung')->count();

    // Tahapan yang diurutkan dari bawah ke atas, tambahkan "Belum Tahapan"
    $tahapan = [
        'Belum Tahapan',
        'Pembentukan Tim',
        'Penyusunan Rencana Kerja',
        'Sosialisasi dan Koordinasi',
        'Evaluasi Awal Kesiapan',
        'BA Hasil Evaluasi Awal Kesiapan OP',
        'Evaluasi Akhir Kesiapan',
        'BA Hasil Evaluasi Akhir Kesiapan OP',
        'Serah Terima hasil OP'
    ];

    // Mengambil data jaringan untuk tahun dan satker yang dipilih
    $jaringans = $query->orderBy('id')->get();

    // Menyiapkan data untuk grafik
    $labels = [];
    $data = [];
    $colors = []; // Untuk menyimpan warna latar belakang berdasarkan jenis jaringan
    $borderColors = []; // Untuk menyimpan warna border berdasarkan jenis jaringan

    foreach ($jaringans as $jaringan) {
        $labels[] = $jaringan->nama . ' (' . $jaringan->jenis . ')';
        $data[] = $jaringan->tahapan ? array_search($jaringan->tahapan, $tahapan) : 0; // Jika tahapan null, set ke "Belum Tahapan"

        // Logika untuk menentukan warna berdasarkan jenis jaringan
        if ($jaringan->jenis == 'Air Tanah') {
            $colors[] = 'rgba(0, 123, 255, 0.7)'; // Primary color untuk Air Tanah
            $borderColors[] = 'rgba(0, 123, 255, 1)';
        } elseif ($jaringan->jenis == 'Air Baku') {
            $colors[] = 'rgba(255, 193, 7, 0.7)'; // Warning color untuk Air Baku
            $borderColors[] = 'rgba(255, 193, 7, 1)';
        } elseif ($jaringan->jenis == 'Embung') {
            $colors[] = 'rgba(40, 167, 69, 0.7)'; // Success color untuk Embung
            $borderColors[] = 'rgba(40, 167, 69, 1)';
        } else {
            $colors[] = 'rgba(153, 102, 255, 0.7)'; // Warna default
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
        'years',
        'selectedYear',
        'selectedSatker' // Tambahkan untuk view
    ));
}

}
