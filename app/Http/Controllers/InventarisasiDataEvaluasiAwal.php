<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Jaringan;
use App\Models\ItemBlanko;
use App\Models\ItemBlanko3;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Blanko2Upload;
use App\Models\EvaluasiBlanko;
use App\Models\ItemBlanko3Rincian;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InventarisasiDataEvaluasiAwal extends Controller
{
    //----------------------------Data dan Informasi  Pekerjaan Fisik------------------------------------------------------
    //----------------------------Blanko 1A-----------------------------------------------------
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

        // Ambil items dari evaluasi blanko
        $items = ItemBlanko::where('evaluasi_blanko_id', $evaluasiBlanko->id)->get();
        //dd($evaluasiBlanko);

        return view('evaluasi.blanko1a', compact('jaringan', 'items', 'evaluasiBlanko'));
    }

    public function prasaranaAirTanahProses(Request $request, Jaringan $jaringan)
    {
        $request->validate([
            'items.*.ada_tidak_ada' => 'nullable|boolean',
            'items.*.bobot' => 'nullable|numeric|min:0|max:100',
            'items.*.kondisi' => 'nullable|numeric|min:0|max:100',
            'items.*.fungsi' => 'nullable|numeric|min:0|max:100',
            'items.*.keterangan' => 'nullable|string|max:255',
            'hasil_ada_tidak_ada' => 'nullable|numeric|min:0|max:100',
            'hasil_kondisi' => 'nullable|numeric|min:0|max:100',
            'hasil_fungsi' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->items as $itemId => $itemData) {
            $item = ItemBlanko::findOrFail($itemId);
            $item->ada_tidak_ada = $itemData['ada_tidak_ada'];
            $item->bobot = $itemData['bobot'];
            $item->kondisi = $itemData['kondisi'];
            $item->fungsi = $itemData['fungsi'];
            $item->keterangan = $itemData['keterangan'];
            $item->save();
        }

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
        if ($tahapan) {
            $evaluasiBlanko = EvaluasiBlanko::where('tahapan_id', $tahapan->id)->where('jenis_blanko', 'Blanko 1A')->first();
            if ($evaluasiBlanko) {
                $evaluasiBlanko->hasil_ada_tidak_ada = $request->input('hasil_ada_tidak_ada');
                $evaluasiBlanko->hasil_kondisi = $request->input('hasil_kondisi');
                $evaluasiBlanko->hasil_fungsi = $request->input('hasil_fungsi');
                $evaluasiBlanko->save();
            }
        }

        // Panggil fungsi untuk memeriksa apakah semua blanko sudah terisi
    $this->checkAllBlankosFilled($jaringan);

    // Hanya set tahapan ke 'Inventarisasi Data dan Informasi' jika tahapan saat ini masih 'Sosialisasi dan Koordinasi'
    if ($jaringan->tahapan === 'Sosialisasi dan Koordinasi') {
        $jaringan->update(['tahapan' => 'Inventarisasi Data dan Informasi']);
    }


        return redirect()->back()->with('success', 'Data evaluasi blanko 1A berhasil disimpan.');
    }

    public function uploadBlanko1a(Request $request, $id)
    {
        try {
            // Validasi file harus berupa PDF dengan ukuran maksimal 3MB
            $request->validate([
                'blanko1a' => 'required|file|mimes:pdf|max:3072', // Max size 3MB
            ]);

            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan berdasarkan nama_tahapan, misalnya 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Pastikan tahapan ditemukan
            if (!$tahapan) {
                return response()->json(['success' => false, 'message' => 'Tahapan tidak ditemukan'], 404);
            }

            // Simpan file dengan nama unik di direktori 'public/blanko1a'
            $file = $request->file('blanko1a')->storeAs('public/blanko1a', uniqid() . '.' . $request->file('blanko1a')->getClientOriginalExtension());

            // Simpan path file dan informasi terkait di database
            Dokumen::create([
                'tahapan_id' => $tahapan->id,
                'nama_dokumen' => 'Blanko 1A',
                'path_dokumen' => $file,
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan yang terjadi dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengunggah dokumen: ' . $e->getMessage()], 500);
        }
    }


    public function deleteBlanko1a($id)
    {
        try {
            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Jika tahapan tidak ditemukan, kembalikan error
            if (!$tahapan) {
                return response()->json(['error' => 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.'], 404);
            }

            // Cari dokumen berdasarkan tahapan dan nama dokumen
            $dokumen = Dokumen::where('tahapan_id', $tahapan->id)->where('nama_dokumen', 'Blanko 1A')->first();

            // Jika dokumen tidak ditemukan, kembalikan error
            if (!$dokumen) {
                return response()->json(['error' => 'Dokumen Blanko 1A tidak ditemukan.'], 404);
            }

            // Hapus file dari storage
            Storage::delete($dokumen->path_dokumen);

            // Hapus data dokumen dari database
            $dokumen->delete();

            // Kembalikan respon sukses
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus dokumen: ' . $e->getMessage()], 500);
        }
    }


    //--------------------------------------------Blanko 1B---------------------------------------
    public function peralatanAirTanah(Jaringan $jaringan)
    {
        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

        if (!$tahapan) {
            return redirect()->back()->with('error', 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.');
        }

        $evaluasiBlanko = EvaluasiBlanko::where('tahapan_id', $tahapan->id)->where('jenis_blanko', 'Blanko 1B')->first();

        if (!$evaluasiBlanko) {
            return redirect()->back()->with('error', 'Evaluasi Blanko 1B tidak ditemukan.');
        }

        $items = ItemBlanko::where('evaluasi_blanko_id', $evaluasiBlanko->id)->get();

        return view('evaluasi.blanko1b', compact('jaringan', 'items', 'evaluasiBlanko'));
    }

    public function peralatanAirTanahProses(Request $request, Jaringan $jaringan)
    {
        $request->validate([
            'items.*.ada_tidak_ada' => 'required|boolean',
            'items.*.bobot' => 'required|numeric|min:0|max:100',
            'items.*.kondisi' => 'required|numeric|min:0|max:100',
            'items.*.fungsi' => 'required|numeric|min:0|max:100',
            'items.*.keterangan' => 'nullable|string|max:255',
            'hasil_ada_tidak_ada' => 'required|numeric|min:0|max:100',
            'hasil_kondisi' => 'required|numeric|min:0|max:100',
            'hasil_fungsi' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($request->items as $itemId => $itemData) {
            $item = ItemBlanko::findOrFail($itemId);
            $item->ada_tidak_ada = $itemData['ada_tidak_ada'];
            $item->bobot = $itemData['bobot'];
            $item->kondisi = $itemData['kondisi'];
            $item->fungsi = $itemData['fungsi'];
            $item->keterangan = $itemData['keterangan'];
            $item->save();
        }

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
        if ($tahapan) {
            $evaluasiBlanko = EvaluasiBlanko::where('tahapan_id', $tahapan->id)->where('jenis_blanko', 'Blanko 1B')->first();
            if ($evaluasiBlanko) {
                $evaluasiBlanko->hasil_ada_tidak_ada = $request->input('hasil_ada_tidak_ada');
                $evaluasiBlanko->hasil_kondisi = $request->input('hasil_kondisi');
                $evaluasiBlanko->hasil_fungsi = $request->input('hasil_fungsi');
                $evaluasiBlanko->save();
            }
        }

         // Panggil fungsi untuk memeriksa apakah semua blanko sudah terisi
    $this->checkAllBlankosFilled($jaringan);

    // Hanya set tahapan ke 'Inventarisasi Data dan Informasi' jika tahapan saat ini masih 'Sosialisasi dan Koordinasi'
    if ($jaringan->tahapan === 'Sosialisasi dan Koordinasi') {
        $jaringan->update(['tahapan' => 'Inventarisasi Data dan Informasi']);
    }
        return redirect()->back()->with('success', 'Data evaluasi blanko 1B berhasil disimpan.');
    }

    public function uploadBlanko1b(Request $request, $id)
    {
        try {
            // Validasi file harus berupa PDF dengan ukuran maksimal 3MB
            $request->validate([
                'blanko1b' => 'required|file|mimes:pdf|max:3072', // Max size 3MB
            ]);

            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan berdasarkan nama_tahapan, misalnya 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Pastikan tahapan ditemukan
            if (!$tahapan) {
                return response()->json(['success' => false, 'message' => 'Tahapan tidak ditemukan'], 404);
            }

            // Simpan file dengan nama unik di direktori 'public/blanko1a'
            $file = $request->file('blanko1b')->storeAs('public/blanko1b', uniqid() . '.' . $request->file('blanko1b')->getClientOriginalExtension());

            // Simpan path file dan informasi terkait di database
            Dokumen::create([
                'tahapan_id' => $tahapan->id,
                'nama_dokumen' => 'Blanko 1B',
                'path_dokumen' => $file,
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan yang terjadi dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengunggah dokumen: ' . $e->getMessage()], 500);
        }
    }

    public function deleteBlanko1b($id)
    {
        try {
            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Jika tahapan tidak ditemukan, kembalikan error
            if (!$tahapan) {
                return response()->json(['error' => 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.'], 404);
            }

            // Cari dokumen berdasarkan tahapan dan nama dokumen
            $dokumen = Dokumen::where('tahapan_id', $tahapan->id)->where('nama_dokumen', 'Blanko 1B')->first();

            // Jika dokumen tidak ditemukan, kembalikan error
            if (!$dokumen) {
                return response()->json(['error' => 'Dokumen Blanko 1B tidak ditemukan.'], 404);
            }

            // Hapus file dari storage
            Storage::delete($dokumen->path_dokumen);

            // Hapus data dokumen dari database
            $dokumen->delete();

            // Kembalikan respon sukses
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus dokumen: ' . $e->getMessage()], 500);
        }
    }

    //--------------------------------------------Blanko 1C---------------------------------------
    public function prasaranaAirBaku(Jaringan $jaringan)
    {
        //dd($jaringan);
        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
        if (!$tahapan) {
            return redirect()->back()->with('error', 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.');
        }
        
        $evaluasiBlanko = EvaluasiBlanko::where('tahapan_id', $tahapan->id)->where('jenis_blanko', 'Blanko 1C')->first();
        
        if (!$evaluasiBlanko) {
            return redirect()->back()->with('error', 'Evaluasi Blanko 1C tidak ditemukan.');
        }

        $items = ItemBlanko::where('evaluasi_blanko_id', $evaluasiBlanko->id)->get();

        return view('evaluasi.blanko1c', compact('jaringan', 'items', 'evaluasiBlanko'));
}

    public function prasaranaAirBakuProses(Request $request, Jaringan $jaringan)
    {
        $request->validate([
            'items.*.ada_tidak_ada' => 'required|boolean',
            'items.*.bobot' => 'required|numeric|min:0|max:100',
            'items.*.kondisi' => 'required|numeric|min:0|max:100',
            'items.*.fungsi' => 'required|numeric|min:0|max:100',
            'items.*.keterangan' => 'nullable|string|max:255',
            'hasil_ada_tidak_ada' => 'required|numeric|min:0|max:100',
            'hasil_kondisi' => 'required|numeric|min:0|max:100',
            'hasil_fungsi' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($request->items as $itemId => $itemData) {
            $item = ItemBlanko::findOrFail($itemId);
            $item->ada_tidak_ada = $itemData['ada_tidak_ada'];
            $item->bobot = $itemData['bobot'];
            $item->kondisi = $itemData['kondisi'];
            $item->fungsi = $itemData['fungsi'];
            $item->keterangan = $itemData['keterangan'];
            $item->save();
        }

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
        if ($tahapan) {
            $evaluasiBlanko = EvaluasiBlanko::where('tahapan_id', $tahapan->id)->where('jenis_blanko', 'Blanko 1C')->first();
            if ($evaluasiBlanko) {
                $evaluasiBlanko->hasil_ada_tidak_ada = $request->input('hasil_ada_tidak_ada');
                $evaluasiBlanko->hasil_kondisi = $request->input('hasil_kondisi');
                $evaluasiBlanko->hasil_fungsi = $request->input('hasil_fungsi');
                $evaluasiBlanko->save();
            }
        }

        // Panggil fungsi untuk memeriksa apakah semua blanko sudah terisi
    $this->checkAllBlankosFilled($jaringan);

    // Hanya set tahapan ke 'Inventarisasi Data dan Informasi' jika tahapan saat ini masih 'Sosialisasi dan Koordinasi'
    if ($jaringan->tahapan === 'Sosialisasi dan Koordinasi') {
        $jaringan->update(['tahapan' => 'Inventarisasi Data dan Informasi']);
    }

        return redirect()->back()->with('success', 'Data evaluasi blanko 1C berhasil disimpan.');
    }

    public function uploadBlanko1c(Request $request, $id)
    {
          try {
            // Validasi file harus berupa PDF dengan ukuran maksimal 3MB
            $request->validate([
                'blanko1c' => 'required|file|mimes:pdf|max:3072', // Max size 3MB
            ]);

            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan berdasarkan nama_tahapan, misalnya 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Pastikan tahapan ditemukan
            if (!$tahapan) {
                return response()->json(['success' => false, 'message' => 'Tahapan tidak ditemukan'], 404);
            }

            // Simpan file dengan nama unik di direktori 'public/blanko1a'
            $file = $request->file('blanko1c')->storeAs('public/blanko1c', uniqid() . '.' . $request->file('blanko1c')->getClientOriginalExtension());

            // Simpan path file dan informasi terkait di database
            Dokumen::create([
                'tahapan_id' => $tahapan->id,
                'nama_dokumen' => 'Blanko 1C',
                'path_dokumen' => $file,
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan yang terjadi dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengunggah dokumen: ' . $e->getMessage()], 500);
        }
    }

    public function deleteBlanko1c($id)
    {
         try {
            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Jika tahapan tidak ditemukan, kembalikan error
            if (!$tahapan) {
                return response()->json(['error' => 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.'], 404);
            }

            // Cari dokumen berdasarkan tahapan dan nama dokumen
            $dokumen = Dokumen::where('tahapan_id', $tahapan->id)->where('nama_dokumen', 'Blanko 1C')->first();

            // Jika dokumen tidak ditemukan, kembalikan error
            if (!$dokumen) {
                return response()->json(['error' => 'Dokumen Blanko 1C tidak ditemukan.'], 404);
            }

            // Hapus file dari storage
            Storage::delete($dokumen->path_dokumen);

            // Hapus data dokumen dari database
            $dokumen->delete();

            // Kembalikan respon sukses
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus dokumen: ' . $e->getMessage()], 500);
        }
    }


    public function ujiPengaliran(Request $request, Jaringan $jaringan)
    {
        //upload dokumen
        $request->validate([
            'dokumen_uji_pengaliran' => 'required|mimes:pdf|max:2048',
        ]);

        $evaluasiAwal = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

        $file1 = $request->file('dokumen_uji_pengaliran')->storeAs('public/uji_pengaliran', uniqid() . '.' . $request->file('dokumen_uji_pengaliran')->getClientOriginalExtension());

        Dokumen::create([
            'tahapan_id' => $evaluasiAwal->id,
            'nama_dokumen' => 'Dokumen Uji Pengaliran',
            'path_dokumen' => $file1,
        ]);

        //di komen dulu
        // $jaringan->update(['tahapan' => 'Uji Pengaliran']);

        return response()->json(['success' => true]);

    }

    public function updateUjiPengaliran(Request $request, Jaringan $jaringan)
    {
        $request->validate([
            'dokumen_uji_pengaliran' => 'file|mimes:pdf|max:2048',
        ]);

        $evaluasiAwal = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

        if ($request->hasFile('dokumen_uji_pengaliran')) {
            $file = $request->file('dokumen_uji_pengaliran')->storeAs('public/uji_pengaliran', uniqid() . '.' . $request->file('dokumen_uji_pengaliran')->getClientOriginalExtension());
            
            Dokumen::updateOrCreate(
                ['tahapan_id' => $evaluasiAwal->id, 'nama_dokumen' => 'Dokumen Uji Pengaliran'],
                ['path_dokumen' => $file]
            );
        }

        return response()->json(['success' => 'Dokumen Uji Pengaliran berhasil diupdate.']);
    }

    //-----------------------------Blanko 2-------------------------------------
    //----------------------------Data dan Informasi  Non-Fisik---------------------------
    public function dataInformasiNonFisik(Jaringan $jaringan)
    {
        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

        if (!$tahapan) {
            return redirect()->back()->with('error', 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.');
        }

        $evaluasiBlanko = $tahapan->evaluasiBlankos()->where('jenis_blanko', 'Blanko 2')->first();

        if (!$evaluasiBlanko) {
            return redirect()->back()->with('error', 'Evaluasi Blanko 2 tidak ditemukan.');
        }

        $items = $evaluasiBlanko->items->map(function($item) {
            $upload = Blanko2Upload::where('item_blanko_id', $item->id)->first();
            if ($upload) {
                $item->file_uploaded = true;
                $item->file_url = asset('storage/blanko2/' . $upload->nama_file);
            } else {
                $item->file_uploaded = false;
                $item->file_url = null;
            }
            return $item;
        });

        return view('evaluasi.blanko2', compact('jaringan', 'items'));
    }


    public function dataInformasiNonFisikProses(Request $request, Jaringan $jaringan)
    {
        // $request->validate([
        //     'items.*.ada_tidak_ada' => 'nullable|boolean',
        //     'items.*.bobot' => 'nullable|numeric|min:0|max:100',
        //     'items.*.keterangan' => 'nullable|string|max:255',
        //     'hasil_ada_tidak_ada' => 'nullable|numeric|min:0|max:100',
        // ]);

        //dd($request);

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

        
        if (!$tahapan) {
            return response()->json(['error' => 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.'], 404);
        }
        
        $evaluasiBlanko = $tahapan->evaluasiBlankos()->where('jenis_blanko', 'Blanko 2')->first();

        // if (!$evaluasiBlanko) {
        //     return response()->json(['error' => 'Evaluasi Blanko 2 tidak ditemukan.'], 404);
        // }

        // // foreach ($request->items as $itemId => $itemData) {
        // //     $item = ItemBlanko::findOrFail($itemId);
        // //     $item->ada_tidak_ada = $itemData['ada_tidak_ada'];
        // //     $item->bobot = $itemData['bobot'];
        // //     $item->keterangan = $itemData['keterangan'];
        // //     $item->save();
        // // }

        $evaluasiBlanko->hasil_ada_tidak_ada = $request->input('hasil_ada_tidak_ada');
        $evaluasiBlanko->save();

        // Panggil fungsi untuk memeriksa apakah semua blanko sudah terisi
    $this->checkAllBlankosFilled($jaringan);

    // Hanya set tahapan ke 'Inventarisasi Data dan Informasi' jika tahapan saat ini masih 'Sosialisasi dan Koordinasi'
    if ($jaringan->tahapan === 'Sosialisasi dan Koordinasi') {
        $jaringan->update(['tahapan' => 'Inventarisasi Data dan Informasi']);
    }

        return redirect()->back()->with('success', 'Data evaluasi blanko 2 berhasil disimpan.');

    }

    public function uploadBlanko2(Request $request, $itemId)
    {
        $request->validate([
            'path_blanko' => 'required|file|mimes:pdf,jpg,png,doc,docx',
        ]);

        $fileName = Str::random(10) . '.' . $request->file('path_blanko')->getClientOriginalExtension();
        $filePath = $request->file('path_blanko')->storeAs('public/blanko2', $fileName);

        // Update or create a record in Blanko2Upload
        Blanko2Upload::updateOrCreate(
            ['item_blanko_id' => $itemId],
            ['nama_file' => $fileName]
        );

        // Update ada_tidak_ada to 1 (Ada) in ItemBlanko
        $itemBlanko = ItemBlanko::findOrFail($itemId);
        $itemBlanko->ada_tidak_ada = 1; // Set to 1 (Ada)
        $itemBlanko->keterangan = 'Dokumen tersedia';
        $itemBlanko->save();
        

        return response()->json([
            'success' => true,
            'message' => 'File berhasil diunggah dan status diperbarui.',
            'item_id' => $itemId,
            'new_status' => 1, // Ada
            'new_keterangan' => 'Dokumen tersedia'
        ]);
    }


    public function deleteBlanko2(Request $request, $itemId)
    {
        $itemBlanko = ItemBlanko::findOrFail($itemId);

        $blankoUpload = Blanko2Upload::where('item_blanko_id', $itemId)->first();

        if ($blankoUpload) {
            // Membangun path lengkap untuk file
            $filePath = 'public/blanko2/' . $blankoUpload->nama_file;

            // Menghapus file dari storage
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            // Menghapus record dari database
            $blankoUpload->delete();
        }

        // Update status item_blanko
        $itemBlanko->ada_tidak_ada = 0;
        $itemBlanko->keterangan = ''; // Set to 0 (Tidak Ada)
        $itemBlanko->save();

        return response()->json(['success' => true, 'message' => 'File berhasil dihapus.']);
    }

    //ini untuk dokumen blanko 2
    public function dokumenBlanko2(Request $request, $id)
    {
        try {
            // Validasi file harus berupa PDF dengan ukuran maksimal 3MB
            $request->validate([
                'blanko2' => 'required|file|mimes:pdf|max:3072', // Max size 3MB
            ]);

            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan berdasarkan nama_tahapan, misalnya 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Pastikan tahapan ditemukan
            if (!$tahapan) {
                return response()->json(['success' => false, 'message' => 'Tahapan tidak ditemukan'], 404);
            }

            // Simpan file dengan nama unik di direktori 'public/blanko1a'
            $file = $request->file('blanko2')->storeAs('public/blanko2', uniqid() . '.' . $request->file('blanko2')->getClientOriginalExtension());

            // Simpan path file dan informasi terkait di database
            Dokumen::create([
                'tahapan_id' => $tahapan->id,
                'nama_dokumen' => 'Blanko 2',
                'path_dokumen' => $file,
            ]);

        return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan yang terjadi dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengunggah dokumen: ' . $e->getMessage()], 500);
        }
    }

    public function deleteDokumenBlanko2($id)
    {
         try {
            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Jika tahapan tidak ditemukan, kembalikan error
            if (!$tahapan) {
                return response()->json(['error' => 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.'], 404);
            }

            // Cari dokumen berdasarkan tahapan dan nama dokumen
            $dokumen = Dokumen::where('tahapan_id', $tahapan->id)->where('nama_dokumen', 'Blanko 2')->first();

            // Jika dokumen tidak ditemukan, kembalikan error
            if (!$dokumen) {
                return response()->json(['error' => 'Dokumen Blanko 2 tidak ditemukan.'], 404);
            }

            // Hapus file dari storage
            Storage::delete($dokumen->path_dokumen);

            // Hapus data dokumen dari database
            $dokumen->delete();

            // Kembalikan respon sukses
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus dokumen: ' . $e->getMessage()], 500);
        }
    }



    //-----------------------------------Blanko 3----------------------------------------//
    //----------------------------Sarana dan Prasarana Pendukung-------------------------//
    //----------------------------Blanko3A-----------------------------//
    public function kesiapanSaranaPenunjangOperasiDanPemeliharaan(Jaringan $jaringan)
    {
        $items = ItemBlanko3::whereHas('evaluasiBlanko', function ($query) use ($jaringan) {
            $query->where('jenis_blanko', 'Blanko 3A')->whereHas('tahapan', function ($query) use ($jaringan) {
                $query->where('jaringan_id', $jaringan->id);
            });
        })->with('rincians')->get();

        return view('evaluasi.blanko3a', compact('jaringan', 'items'));
    }

    public function kesiapanSaranaPenunjangOperasiDanPemeliharaanProses(Request $request, Jaringan $jaringan)
    {
        // Validasi data dari form
        $request->validate([
            'items.*.rincian.*.bobot' => 'nullable|numeric|min:0|max:100',
            'items.*.rincian.*.ada_tidak_ada' => 'nullable|boolean',
            'items.*.rincian.*.kondisi' => 'nullable|numeric|min:0|max:100',
            'items.*.rincian.*.fungsi' => 'nullable|numeric|min:0|max:100',
            'items.*.rincian.*.keterangan' => 'nullable|string|max:255',
            'hasil_ada_tidak_ada' => 'nullable|numeric|min:0|max:100',
            'hasil_kondisi' => 'nullable|numeric|min:0|max:100',
            'hasil_fungsi' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->items as $itemId => $itemData) {
            foreach ($itemData['rincian'] as $rincianId => $rincianData) {
                $rincian = ItemBlanko3Rincian::findOrFail($rincianId);
                $rincian->bobot = $rincianData['bobot'];
                $rincian->ada_tidak_ada = $rincianData['ada_tidak_ada'];
                $rincian->kondisi = $rincianData['kondisi'];
                $rincian->fungsi = $rincianData['fungsi'];
                $rincian->keterangan = $rincianData['keterangan'];
                $rincian->save();
            }
        }

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
        if ($tahapan) {
            $evaluasiBlanko = EvaluasiBlanko::where('tahapan_id', $tahapan->id)
                                            ->where('jenis_blanko', 'Blanko 3A')
                                            ->first();
            if ($evaluasiBlanko) {
                $evaluasiBlanko->hasil_ada_tidak_ada = $request->input('hasil_ada_tidak_ada');
                $evaluasiBlanko->hasil_kondisi = $request->input('hasil_kondisi');
                $evaluasiBlanko->hasil_fungsi = $request->input('hasil_fungsi');
                $evaluasiBlanko->save();
            }
        }

         // Panggil fungsi untuk memeriksa apakah semua blanko sudah terisi
    $this->checkAllBlankosFilled($jaringan);

    // Hanya set tahapan ke 'Inventarisasi Data dan Informasi' jika tahapan saat ini masih 'Sosialisasi dan Koordinasi'
    if ($jaringan->tahapan === 'Sosialisasi dan Koordinasi') {
        $jaringan->update(['tahapan' => 'Inventarisasi Data dan Informasi']);
    }

        return redirect()->back()->with('success', 'Data evaluasi blanko 3A berhasil disimpan.');
    }

    public function uploadBlanko3a(Request $request, $id)
    {
        try {
            // Validasi file harus berupa PDF dengan ukuran maksimal 3MB
            $request->validate([
                'blanko3a' => 'required|file|mimes:pdf|max:3072', // Max size 3MB
            ]);

            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan berdasarkan nama_tahapan, misalnya 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Pastikan tahapan ditemukan
            if (!$tahapan) {
                return response()->json(['success' => false, 'message' => 'Tahapan tidak ditemukan'], 404);
            }

            // Simpan file dengan nama unik di direktori 'public/blanko3a'
            $file = $request->file('blanko3a')->storeAs('public/blanko3a', uniqid() . '.' . $request->file('blanko3a')->getClientOriginalExtension());

            // Simpan path file dan informasi terkait di database
            Dokumen::create([
                'tahapan_id' => $tahapan->id,
                'nama_dokumen' => 'Blanko 3A',
                'path_dokumen' => $file,
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan yang terjadi dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengunggah dokumen: ' . $e->getMessage()], 500);
        }
    }

    public function deleteBlanko3a($id)
    {
        try {
            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Jika tahapan tidak ditemukan, kembalikan error
            if (!$tahapan) {
                return response()->json(['error' => 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.'], 404);
            }

            // Cari dokumen berdasarkan tahapan dan nama dokumen
            $dokumen = Dokumen::where('tahapan_id', $tahapan->id)->where('nama_dokumen', 'Blanko 3A')->first();

            // Jika dokumen tidak ditemukan, kembalikan error
            if (!$dokumen) {
                return response()->json(['error' => 'Dokumen Blanko 3A tidak ditemukan.'], 404);
            }

            // Hapus file dari storage
            Storage::delete($dokumen->path_dokumen);

            // Hapus data dokumen dari database
            $dokumen->delete();

            // Kembalikan respon sukses
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus dokumen: ' . $e->getMessage()], 500);
        }
    }



    //----------------------------Blanko3B-----------------------------//
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
        // Validasi data dari form
        $request->validate([
            'items.*.rincian.*.bobot' => 'nullable|numeric|min:0|max:100',
            'items.*.rincian.*.ada_tidak_ada' => 'nullable|boolean',
            'items.*.rincian.*.kondisi' => 'nullable|numeric|min:0|max:100',
            'items.*.rincian.*.fungsi' => 'nullable|numeric|min:0|max:100',
            'items.*.rincian.*.keterangan' => 'nullable|string|max:255',
            'hasil_ada_tidak_ada' => 'nullable|numeric|min:0|max:100',
            'hasil_kondisi' => 'nullable|numeric|min:0|max:100',
            'hasil_fungsi' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->items as $itemId => $itemData) {
            foreach ($itemData['rincian'] as $rincianId => $rincianData) {
                $rincian = ItemBlanko3Rincian::findOrFail($rincianId);
                $rincian->bobot = $rincianData['bobot'];
                $rincian->ada_tidak_ada = $rincianData['ada_tidak_ada'];
                $rincian->kondisi = $rincianData['kondisi'];
                $rincian->fungsi = $rincianData['fungsi'];
                $rincian->keterangan = $rincianData['keterangan'];
                $rincian->save();
            }
        }

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
        if ($tahapan) {
            $evaluasiBlanko = EvaluasiBlanko::where('tahapan_id', $tahapan->id)
                                            ->where('jenis_blanko', 'Blanko 3B')
                                            ->first();
            if ($evaluasiBlanko) {
                $evaluasiBlanko->hasil_ada_tidak_ada = $request->input('hasil_ada_tidak_ada');
                $evaluasiBlanko->hasil_kondisi = $request->input('hasil_kondisi');
                $evaluasiBlanko->hasil_fungsi = $request->input('hasil_fungsi');
                $evaluasiBlanko->save();
            }
        }

        // Panggil fungsi untuk memeriksa apakah semua blanko sudah terisi
    $this->checkAllBlankosFilled($jaringan);

    // Hanya set tahapan ke 'Inventarisasi Data dan Informasi' jika tahapan saat ini masih 'Sosialisasi dan Koordinasi'
    if ($jaringan->tahapan === 'Sosialisasi dan Koordinasi') {
        $jaringan->update(['tahapan' => 'Inventarisasi Data dan Informasi']);
    }

        return redirect()->back()->with('success', 'Data evaluasi blanko 3B berhasil disimpan.');

    }

    public function uploadBlanko3b(Request $request, $id)
    {
        try {
            // Validasi file harus berupa PDF dengan ukuran maksimal 3MB
            $request->validate([
                'blanko3b' => 'required|file|mimes:pdf|max:3072', // Max size 3MB
            ]);

            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan berdasarkan nama_tahapan, misalnya 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Pastikan tahapan ditemukan
            if (!$tahapan) {
                return response()->json(['success' => false, 'message' => 'Tahapan tidak ditemukan'], 404);
            }

            // Simpan file dengan nama unik di direktori 'public/blanko3b'
            $file = $request->file('blanko3b')->storeAs('public/blanko3b', uniqid() . '.' . $request->file('blanko3b')->getClientOriginalExtension());

            // Simpan path file dan informasi terkait di database
            Dokumen::create([
                'tahapan_id' => $tahapan->id,
                'nama_dokumen' => 'Blanko 3B',
                'path_dokumen' => $file,
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan yang terjadi dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengunggah dokumen: ' . $e->getMessage()], 500);
        }
    }

    public function deleteBlanko3b($id)
    {
        try {
            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Jika tahapan tidak ditemukan, kembalikan error
            if (!$tahapan) {
                return response()->json(['error' => 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.'], 404);
            }

            // Cari dokumen berdasarkan tahapan dan nama dokumen
            $dokumen = Dokumen::where('tahapan_id', $tahapan->id)->where('nama_dokumen', 'Blanko 3B')->first();

            // Jika dokumen tidak ditemukan, kembalikan error
            if (!$dokumen) {
                return response()->json(['error' => 'Dokumen Blanko 3B tidak ditemukan.'], 404);
            }

            // Hapus file dari storage
            Storage::delete($dokumen->path_dokumen);

            // Hapus data dokumen dari database
            $dokumen->delete();

            // Kembalikan respon sukses
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus dokumen: ' . $e->getMessage()], 500);
        }
    }


    //----------------------------Blanko3C-----------------------------//
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
        // Validasi data dari form
        $request->validate([
            'items.*.rincian.*.bobot' => 'nullable|numeric|min:0|max:100',
            'items.*.rincian.*.ada_tidak_ada' => 'nullable|boolean',
            'items.*.rincian.*.kondisi' => 'nullable|numeric|min:0|max:100',
            'items.*.rincian.*.fungsi' => 'nullable|numeric|min:0|max:100',
            'items.*.rincian.*.keterangan' => 'nullable|string|max:255',
            'hasil_ada_tidak_ada' => 'nullable|numeric|min:0|max:100',
            'hasil_kondisi' => 'nullable|numeric|min:0|max:100',
            'hasil_fungsi' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->items as $itemId => $itemData) {
            foreach ($itemData['rincian'] as $rincianId => $rincianData) {
                $rincian = ItemBlanko3Rincian::findOrFail($rincianId);
                $rincian->bobot = $rincianData['bobot'];
                $rincian->ada_tidak_ada = $rincianData['ada_tidak_ada'];
                $rincian->kondisi = $rincianData['kondisi'];
                $rincian->fungsi = $rincianData['fungsi'];
                $rincian->keterangan = $rincianData['keterangan'];
                $rincian->save();
            }
        }

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
        if ($tahapan) {
            $evaluasiBlanko = EvaluasiBlanko::where('tahapan_id', $tahapan->id)
                                            ->where('jenis_blanko', 'Blanko 3C')
                                            ->first();
            if ($evaluasiBlanko) {
                $evaluasiBlanko->hasil_ada_tidak_ada = $request->input('hasil_ada_tidak_ada');
                $evaluasiBlanko->hasil_kondisi = $request->input('hasil_kondisi');
                $evaluasiBlanko->hasil_fungsi = $request->input('hasil_fungsi');
                $evaluasiBlanko->save();
            }
        }

        // Panggil fungsi untuk memeriksa apakah semua blanko sudah terisi
    $this->checkAllBlankosFilled($jaringan);

    // Hanya set tahapan ke 'Inventarisasi Data dan Informasi' jika tahapan saat ini masih 'Sosialisasi dan Koordinasi'
    if ($jaringan->tahapan === 'Sosialisasi dan Koordinasi') {
        $jaringan->update(['tahapan' => 'Inventarisasi Data dan Informasi']);
    }
        return redirect()->back()->with('success', 'Data evaluasi blanko 3C berhasil disimpan.');
    }

    public function uploadBlanko3c(Request $request, $id)
    {
        try {
            // Validasi file harus berupa PDF dengan ukuran maksimal 3MB
            $request->validate([
                'blanko3c' => 'required|file|mimes:pdf|max:3072', // Max size 3MB
            ]);

            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan berdasarkan nama_tahapan, misalnya 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Pastikan tahapan ditemukan
            if (!$tahapan) {
                return response()->json(['success' => false, 'message' => 'Tahapan tidak ditemukan'], 404);
            }

            // Simpan file dengan nama unik di direktori 'public/blanko3c'
            $file = $request->file('blanko3c')->storeAs('public/blanko3c', uniqid() . '.' . $request->file('blanko3c')->getClientOriginalExtension());

            // Simpan path file dan informasi terkait di database
            Dokumen::create([
                'tahapan_id' => $tahapan->id,
                'nama_dokumen' => 'Blanko 3C',
                'path_dokumen' => $file,
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan yang terjadi dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengunggah dokumen: ' . $e->getMessage()], 500);
        }
    }

    public function deleteBlanko3c($id)
    {
        try {
            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Jika tahapan tidak ditemukan, kembalikan error
            if (!$tahapan) {
                return response()->json(['error' => 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.'], 404);
            }

            // Cari dokumen berdasarkan tahapan dan nama dokumen
            $dokumen = Dokumen::where('tahapan_id', $tahapan->id)->where('nama_dokumen', 'Blanko 3C')->first();

            // Jika dokumen tidak ditemukan, kembalikan error
            if (!$dokumen) {
                return response()->json(['error' => 'Dokumen Blanko 3C tidak ditemukan.'], 404);
            }

            // Hapus file dari storage
            Storage::delete($dokumen->path_dokumen);

            // Hapus data dokumen dari database
            $dokumen->delete();

            // Kembalikan respon sukses
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus dokumen: ' . $e->getMessage()], 500);
        }
    }


    //----------------------------Blanko3D-----------------------------//
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
        // Validasi data dari form
        $request->validate([
            'items.*.rincian.*.bobot' => 'nullable|numeric|min:0|max:100',
            'items.*.rincian.*.ada_tidak_ada' => 'nullable|boolean',
            'items.*.rincian.*.kondisi' => 'nullable|numeric|min:0|max:100',
            'items.*.rincian.*.fungsi' => 'nullable|numeric|min:0|max:100',
            'items.*.rincian.*.keterangan' => 'nullable|string|max:255',
            'hasil_ada_tidak_ada' => 'nullable|numeric|min:0|max:100',
            'hasil_kondisi' => 'nullable|numeric|min:0|max:100',
            'hasil_fungsi' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->items as $itemId => $itemData) {
            foreach ($itemData['rincian'] as $rincianId => $rincianData) {
                $rincian = ItemBlanko3Rincian::findOrFail($rincianId);
                $rincian->bobot = $rincianData['bobot'];
                $rincian->ada_tidak_ada = $rincianData['ada_tidak_ada'];
                $rincian->kondisi = $rincianData['kondisi'];
                $rincian->fungsi = $rincianData['fungsi'];
                $rincian->keterangan = $rincianData['keterangan'];
                $rincian->save();
            }
        }

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
        if ($tahapan) {
            $evaluasiBlanko = EvaluasiBlanko::where('tahapan_id', $tahapan->id)
                                            ->where('jenis_blanko', 'Blanko 3D')
                                            ->first();
            if ($evaluasiBlanko) {
                $evaluasiBlanko->hasil_ada_tidak_ada = $request->input('hasil_ada_tidak_ada');
                $evaluasiBlanko->hasil_kondisi = $request->input('hasil_kondisi');
                $evaluasiBlanko->hasil_fungsi = $request->input('hasil_fungsi');
                $evaluasiBlanko->save();
            }
        }

         // Panggil fungsi untuk memeriksa apakah semua blanko sudah terisi
    $this->checkAllBlankosFilled($jaringan);

    // Hanya set tahapan ke 'Inventarisasi Data dan Informasi' jika tahapan saat ini masih 'Sosialisasi dan Koordinasi'
    if ($jaringan->tahapan === 'Sosialisasi dan Koordinasi') {
        $jaringan->update(['tahapan' => 'Inventarisasi Data dan Informasi']);
    }
         return redirect()->back()->with('success', 'Data evaluasi blanko 3D berhasil disimpan.');
    }

    public function uploadBlanko3d(Request $request, $id)
    {
        try {
            // Validasi file harus berupa PDF dengan ukuran maksimal 3MB
            $request->validate([
                'blanko3d' => 'required|file|mimes:pdf|max:3072', // Max size 3MB
            ]);

            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan berdasarkan nama_tahapan, misalnya 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Pastikan tahapan ditemukan
            if (!$tahapan) {
                return response()->json(['success' => false, 'message' => 'Tahapan tidak ditemukan'], 404);
            }

            // Simpan file dengan nama unik di direktori 'public/blanko3c'
            $file = $request->file('blanko3d')->storeAs('public/blanko3d', uniqid() . '.' . $request->file('blanko3d')->getClientOriginalExtension());

            // Simpan path file dan informasi terkait di database
            Dokumen::create([
                'tahapan_id' => $tahapan->id,
                'nama_dokumen' => 'Blanko 3D',
                'path_dokumen' => $file,
            ]);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan yang terjadi dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengunggah dokumen: ' . $e->getMessage()], 500);
        }
    }

    public function deleteBlanko3d($id)
    {
         try {
            $jaringan = Jaringan::findOrFail($id);

            // Cari tahapan 'Evaluasi Awal Kesiapan'
            $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();

            // Jika tahapan tidak ditemukan, kembalikan error
            if (!$tahapan) {
                return response()->json(['error' => 'Tahapan Evaluasi Awal Kesiapan tidak ditemukan.'], 404);
            }

            // Cari dokumen berdasarkan tahapan dan nama dokumen
            $dokumen = Dokumen::where('tahapan_id', $tahapan->id)->where('nama_dokumen', 'Blanko 3D')->first();

            // Jika dokumen tidak ditemukan, kembalikan error
            if (!$dokumen) {
                return response()->json(['error' => 'Dokumen Blanko 3D tidak ditemukan.'], 404);
            }

            // Hapus file dari storage
            Storage::delete($dokumen->path_dokumen);

            // Hapus data dokumen dari database
            $dokumen->delete();

            // Kembalikan respon sukses
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Tangani kesalahan dan kembalikan respons error dengan pesan kesalahan
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus dokumen: ' . $e->getMessage()], 500);
        }
    }


    //cek blanko untuk status tahapan
   private function checkAllBlankosFilled(Jaringan $jaringan)
{
    // Daftar tahapan berurutan
    $tahapanList = [
        'Pembentukan Tim',
        'Penyusunan Rencana Kerja',
        'Sosialisasi dan Koordinasi',
        'Inventarisasi Data dan Informasi',
        'Evaluasi Awal Kesiapan OP',
        'Evaluasi Akhir Kesiapan OP',
        'Serah Terima hasil OP'
    ];

    // Ambil tahapan saat ini
    $currentTahapan = $jaringan->tahapan;

    // Cari indeks tahapan saat ini dalam daftar tahapan
    $currentIndex = array_search($currentTahapan, $tahapanList);

    // Pastikan tidak mundur dari tahapan saat ini
    if ($currentIndex !== false && $currentIndex < count($tahapanList) - 1) {
        // Logika untuk memeriksa apakah semua kriteria terpenuhi untuk maju ke tahap selanjutnya
        $allFilled = $this->areAllBlankosFilled($jaringan); // Implementasikan fungsi ini untuk memeriksa validasi

        // Jika semua kriteria terpenuhi, maju ke tahapan berikutnya
        if ($allFilled) {
            // Periksa apakah jaringan belum pernah melewati tahapan 'Inventarisasi Data dan Informasi'
            if ($currentTahapan === 'Sosialisasi dan Koordinasi') {
                $nextTahapan = 'Inventarisasi Data dan Informasi';
                $jaringan->update(['tahapan' => $nextTahapan]);
            } else {
                // Jangan ubah tahapan jika sudah melewati 'Inventarisasi Data dan Informasi'
                if ($currentTahapan !== 'Inventarisasi Data dan Informasi') {
                    $nextTahapan = $tahapanList[$currentIndex + 1];
                    $jaringan->update(['tahapan' => $nextTahapan]);
                }
            }
        }
    }
}

private function areAllBlankosFilled(Jaringan $jaringan)
{
    // Ambil tahapan 'Evaluasi Awal Kesiapan'
    $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Evaluasi Awal Kesiapan')->first();
    
    if ($tahapan) {
        // Cek apakah semua blanko yang relevan telah terisi berdasarkan jenis jaringan
        switch ($jaringan->jenis) {
            case 'Air Tanah':
                return $this->checkBlankosFilledForAirTanah($tahapan);
            case 'Air Baku':
            case 'Embung':
                return $this->checkBlankosFilledForAirBakuOrEmbung($tahapan);
            default:
                return false;
        }
    }

    return false;
}

private function checkBlankosFilledForAirTanah($tahapan)
{
    $blankos = ['Blanko 1A', 'Blanko 1B', 'Blanko 2', 'Blanko 3A', 'Blanko 3B', 'Blanko 3C', 'Blanko 3D'];
    
    foreach ($blankos as $blanko) {
        $evaluasiBlanko = EvaluasiBlanko::where('tahapan_id', $tahapan->id)->where('jenis_blanko', $blanko)->first();
        if (!$evaluasiBlanko || $evaluasiBlanko->hasil_ada_tidak_ada < 1) {
            return false; // Jika ada blanko yang belum terisi, kembalikan false
        }
    }

    return true; // Semua blanko terisi
}

private function checkBlankosFilledForAirBakuOrEmbung($tahapan)
{
    $blankos = ['Blanko 1C', 'Blanko 2', 'Blanko 3A', 'Blanko 3B', 'Blanko 3C', 'Blanko 3D'];

    foreach ($blankos as $blanko) {
        $evaluasiBlanko = EvaluasiBlanko::where('tahapan_id', $tahapan->id)->where('jenis_blanko', $blanko)->first();
        if (!$evaluasiBlanko || $evaluasiBlanko->hasil_ada_tidak_ada < 1) {
            return false; // Jika ada blanko yang belum terisi, kembalikan false
        }
    }

    return true; // Semua blanko terisi
}

}
