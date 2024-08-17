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

    // Menghitung total jaringan berdasarkan tahun yang dipilih
    $totalJaringan = Jaringan::where('tahun', $selectedYear)->count();

    // Menghitung total untuk setiap jenis jaringan berdasarkan tahun yang dipilih
    $totalAirTanah = Jaringan::where('jenis', 'Air Tanah')->where('tahun', $selectedYear)->count();
    $totalAirBaku = Jaringan::where('jenis', 'Air Baku')->where('tahun', $selectedYear)->count();
    $totalEmbung = Jaringan::where('jenis', 'Embung')->where('tahun', $selectedYear)->count();

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

    // Mengambil data jaringan untuk tahun yang dipilih
    $jaringans = Jaringan::where('tahun', $selectedYear)->orderBy('id')->get();

    // Menyiapkan data untuk grafik
    $labels = [];
    $data = [];
    foreach ($jaringans as $jaringan) {
        $labels[] = $jaringan->nama . ' (' . $jaringan->jenis . ')';
        $data[] = $jaringan->tahapan ? array_search($jaringan->tahapan, $tahapan) : 0; // Jika tahapan null, set ke "Belum Tahapan"
    }

    return view('home', compact(
        'totalJaringan',
        'totalAirTanah',
        'totalAirBaku',
        'totalEmbung',
        'tahapan',
        'labels',
        'data',
        'years',
        'selectedYear'
    ));
}













}
