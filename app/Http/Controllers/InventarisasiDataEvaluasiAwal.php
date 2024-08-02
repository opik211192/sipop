<?php

namespace App\Http\Controllers;

use App\Models\Jaringan;
use App\Models\ItemBlanko;
use App\Models\ItemBlanko3;
use Illuminate\Http\Request;
use App\Models\EvaluasiBlanko;
use App\Models\ItemBlanko3Rincian;

class InventarisasiDataEvaluasiAwal extends Controller
{
    //----------------------------Data dan Informasi  Pekerjaan Fisik---------------------------
    public function prasaranaAirTanah(Jaringan $jaringan)
    {
        // Temukan tahapan Evaluasi Awal Kesiapan
        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
        
        if (!$tahapan) {
            return redirect()->back()->with('error', 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.');
        }

        // Temukan evaluasi blanko
        $evaluasiBlanko = EvaluasiBlanko::where('tahapan_id', $tahapan->id)->where('jenis_blanko', 'Blanko 1A')->first();
        
        if (!$evaluasiBlanko) {
            return redirect()->back()->with('error', 'Evaluasi Blanko 1A tidak ditemukan.');
        }

        $items = ItemBlanko::where('evaluasi_blanko_id', $evaluasiBlanko->id)->get();

        return view('evaluasi.blanko1a', compact('jaringan', 'items'));
    }

   public function prasaranaAirTanahProses(Request $request, Jaringan $jaringan)
    {
        // Validasi data dari form
        $request->validate([
            'items.*.ada_tidak_ada' => 'required|boolean',
            'items.*.kondisi' => 'required|numeric|min:0|max:100',
            'items.*.fungsi' => 'required|numeric|min:0|max:100',
            'items.*.keterangan' => 'nullable|string|max:255',
        ]);

        // Update items with data from the form
        foreach ($request->items as $itemId => $itemData) {
            $item = ItemBlanko::findOrFail($itemId);
            $item->ada_tidak_ada = $itemData['ada_tidak_ada'];
            $item->kondisi = $itemData['kondisi'];
            $item->fungsi = $itemData['fungsi'];
            $item->keterangan = $itemData['keterangan'];
            $item->save();
        }

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui.']);
    }

    public function peralatanAirTanah(Jaringan $jaringan)
    {
        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

        if (!$tahapan) {
            return redirect()->back()->with('error', 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.');
        }

        $evaluasiBlanko = $tahapan->evaluasiBlankos()->where('jenis_blanko', 'Blanko 1B')->first();

        if (!$evaluasiBlanko) {
            return redirect()->back()->with('error', 'Evaluasi Blanko 1B tidak ditemukan.');
        }

        $items = $evaluasiBlanko->items;

        return view('evaluasi.blanko1b', compact('jaringan', 'items'));
    }

    public function peralatanAirTanahProses(Request $request, Jaringan $jaringan)
    {
        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

        if (!$tahapan) {
            return response()->json(['error' => 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.'], 404);
        }

        $evaluasiBlanko = $tahapan->evaluasiBlankos()->where('jenis_blanko', 'Blanko 1B')->first();

        if (!$evaluasiBlanko) {
            return response()->json(['error' => 'Evaluasi Blanko 1B tidak ditemukan.'], 404);
        }

        foreach ($request->items as $itemId => $itemData) {
            $item = ItemBlanko::findOrFail($itemId);
            $item->ada_tidak_ada = $itemData['ada_tidak_ada'];
            $item->kondisi = $itemData['kondisi'];
            $item->fungsi = $itemData['fungsi'];
            $item->keterangan = $itemData['keterangan'];
            $item->save();
        }

        return response()->json(['success' => 'Data berhasil disimpan.']);
    }

   public function prasaranaAirBaku(Jaringan $jaringan)
    {
        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

        if (!$tahapan) {
            return redirect()->back()->with('error', 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.');
        }

        $evaluasiBlanko = $tahapan->evaluasiBlankos()->where('jenis_blanko', 'Blanko 1C')->first();

        if (!$evaluasiBlanko) {
            return redirect()->back()->with('error', 'Evaluasi Blanko 1C tidak ditemukan.');
        }

        $items = $evaluasiBlanko->items;

        return view('evaluasi.blanko1c', compact('jaringan', 'items'));
    }

    public function prasaranaAirBakuProses(Request $request, Jaringan $jaringan)
    {
        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

        if (!$tahapan) {
            return response()->json(['error' => 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.'], 404);
        }

        $evaluasiBlanko = $tahapan->evaluasiBlankos()->where('jenis_blanko', 'Blanko 1C')->first();

        if (!$evaluasiBlanko) {
            return response()->json(['error' => 'Evaluasi Blanko 1C tidak ditemukan.'], 404);
        }

        foreach ($request->items as $itemId => $itemData) {
            $item = ItemBlanko::findOrFail($itemId);
            $item->ada_tidak_ada = $itemData['ada_tidak_ada'];
            $item->kondisi = $itemData['kondisi'];
            $item->fungsi = $itemData['fungsi'];
            $item->keterangan = $itemData['keterangan'];
            $item->save();
        }

        return response()->json(['success' => 'Data berhasil disimpan.']);
    }

    public function ujiPengaliran()
    {
        //upload dokumen
    }

    //----------------------------Data dan Informasi  Non-Fisik---------------------------
   public function dataInformasiNonFisik(Jaringan $jaringan)
    {
        $evaluasiAwal = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
        $evaluasiBlanko = $evaluasiAwal ? $evaluasiAwal->evaluasiBlankos()->where('jenis_blanko', 'Blanko 2')->first() : null;
        $items = $evaluasiBlanko ? $evaluasiBlanko->items : collect();

        return view('evaluasi.blanko2', compact('jaringan', 'items'));
    }

    public function dataInformasiNonFisikProses(Request $request, Jaringan $jaringan)
    {
        $evaluasiAwal = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
        $evaluasiBlanko = $evaluasiAwal ? $evaluasiAwal->evaluasiBlankos()->where('jenis_blanko', 'Blanko 2')->first() : null;

        if ($evaluasiBlanko) {
            foreach ($request->items as $itemId => $itemData) {
                $item = ItemBlanko::findOrFail($itemId);
                $item->ada_tidak_ada = $itemData['ada_tidak_ada'];
                $item->kondisi = $itemData['kondisi'];
                $item->fungsi = $itemData['fungsi'];
                $item->keterangan = $itemData['keterangan'];
                $item->save();
            }
        }

        return response()->json(['success' => true]);
    }


    //-----------------------------------Blanko 3----------------------------------------//
    //----------------------------Sarana dan Prasarana Pendukung-------------------------//
    public function kesiapanSaranaPenunjangOperasiDanPemeliharaan(Jaringan $jaringan)
    {
        $items = ItemBlanko3::whereHas('evaluasiBlanko', function ($query) use ($jaringan) {
            $query->where('jenis_blanko', 'Blanko 3A')->whereHas('tahapan', function ($query) use ($jaringan) {
                $query->where('jaringan_id', $jaringan->id);
            });
        })->with('rincians')->get();

        // dd($items);

        return view('evaluasi.blanko3a', compact('jaringan', 'items'));
    }

    public function kesiapanSaranaPenunjangOperasiDanPemeliharaanProses(Request $request, Jaringan $jaringan)
    {
        foreach ($request->items as $itemId => $itemData) {
            foreach ($itemData['rincian'] as $rincianId => $rincianData) {
                $rincian = ItemBlanko3Rincian::findOrFail($rincianId);
                $rincian->ada_tidak_ada = $rincianData['ada_tidak_ada'];
                $rincian->kondisi = $rincianData['kondisi'];
                $rincian->fungsi = $rincianData['fungsi'];
                $rincian->keterangan = $rincianData['keterangan'];
                $rincian->save();
            }
        }

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }

    public function kesiapanKelembagaanDanSumberDayaManusia(Jaringan $jaringan)
    {
        $items = ItemBlanko3::whereHas('evaluasiBlanko', function ($query) use ($jaringan) {
            $query->where('jenis_blanko', 'Blanko 3B')->whereHas('tahapan', function ($query) use ($jaringan) {
                $query->where('jaringan_id', $jaringan->id);
            });
        })->with('rincians')->get();

        return view('evaluasi.blanko3b', compact('jaringan', 'items'));
    }

    public function kesiapanKelembagaanDanSumberDayaManusiaProses(Request $request, Jaringan $jaringan)
    {
        // Update items with data from the form
        foreach ($request->items as $itemId => $itemData) {
            foreach ($itemData['rincian'] as $rincianId => $rincianData) {
                $rincian = ItemBlanko3Rincian::findOrFail($rincianId);
                $rincian->ada_tidak_ada = $rincianData['ada_tidak_ada'];
                $rincian->kondisi = $rincianData['kondisi'];
                $rincian->fungsi = $rincianData['fungsi'];
                $rincian->keterangan = $rincianData['keterangan'];
                $rincian->save();
            }
        }

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }

   public function kesiapanManajemen(Jaringan $jaringan)
    {
        $items = ItemBlanko3::whereHas('evaluasiBlanko', function ($query) use ($jaringan) {
            $query->where('jenis_blanko', 'Blanko 3C')->whereHas('tahapan', function ($query) use ($jaringan) {
                $query->where('jaringan_id', $jaringan->id);
            });
        })->with('rincians')->get();

        return view('evaluasi.blanko3c', compact('jaringan', 'items'));
    }

    public function kesiapanManajemenProses(Request $request, Jaringan $jaringan)
    {
        // Update items with data from the form
        foreach ($request->items as $itemId => $itemData) {
            foreach ($itemData['rincian'] as $rincianId => $rincianData) {
                $rincian = ItemBlanko3Rincian::findOrFail($rincianId);
                $rincian->ada_tidak_ada = $rincianData['ada_tidak_ada'];
                $rincian->kondisi = $rincianData['kondisi'];
                $rincian->fungsi = $rincianData['fungsi'];
                $rincian->keterangan = $rincianData['keterangan'];
                $rincian->save();
            }
        }

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }

    public function kesiapanKonservasi(Jaringan $jaringan)
    {
        $items = ItemBlanko3::whereHas('evaluasiBlanko', function ($query) use ($jaringan) {
            $query->where('jenis_blanko', 'Blanko 3D')->whereHas('tahapan', function ($query) use ($jaringan) {
                $query->where('jaringan_id', $jaringan->id);
            });
        })->with('rincians')->get();

        return view('evaluasi.blanko3d', compact('jaringan', 'items'));
    }

    public function kesiapanKonservasiProses(Request $request, Jaringan $jaringan)
    {
        // Update items with data from the form
        foreach ($request->items as $itemId => $itemData) {
            foreach ($itemData['rincian'] as $rincianId => $rincianData) {
                $rincian = ItemBlanko3Rincian::findOrFail($rincianId);
                $rincian->ada_tidak_ada = $rincianData['ada_tidak_ada'];
                $rincian->kondisi = $rincianData['kondisi'];
                $rincian->fungsi = $rincianData['fungsi'];
                $rincian->keterangan = $rincianData['keterangan'];
                $rincian->save();
            }
        }

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }
}
