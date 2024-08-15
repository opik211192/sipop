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

        // Tahapan yang diurutkan sesuai dengan urutan yang diinginkan
        $tahapan = [
            'Pembentukan Tim',
            'Penyusunan Rencana Kerja',
            'Sosialisasi dan Koordinasi',
            'Evaluasi Awal Kesiapan',
            'BA Hasil Evaluasi Awal Kesiapan OP',
            'Evaluasi Akhir Kesiapan',
            'BA Hasil Evaluasi Akhir Kesiapan OP',
            'Serah Terima hasil OP'
        ];

        // Menghitung jumlah jaringan di setiap tahapan berdasarkan tahun yang dipilih
        $jumlahTahapan = [];
        $jaringanInfo = [];

        foreach ($tahapan as $namaTahapan) {
            $jumlahTahapan[$namaTahapan] = Jaringan::where('tahapan', $namaTahapan)
                                ->where('tahun', $selectedYear)
                                ->count();

            // Mengambil nama jaringan dan tahun untuk setiap tahapan
            $jaringanData = Jaringan::where('tahapan', $namaTahapan)
                                    ->where('tahun', $selectedYear)
                                    ->get(['nama', 'jenis', 'tahun']);
            $jaringanInfo[$namaTahapan] = $jaringanData->map(function($jaringan) {
                return $jaringan->nama . ' (' . $jaringan->jenis . ') (' . $jaringan->tahun . ')';
            })->toArray();
        }

        // Menggunakan total jaringan sebagai maxJumlah
        $maxJumlah = $totalJaringan;

        return view('home', compact('totalJaringan', 'totalAirTanah', 'totalAirBaku', 'totalEmbung', 'jumlahTahapan', 'tahapan', 'jaringanInfo', 'years', 'selectedYear', 'maxJumlah'));
    }











}
