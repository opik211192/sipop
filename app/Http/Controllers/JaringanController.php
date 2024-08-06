<?php

namespace App\Http\Controllers;


use App\Models\Dokumen;
use App\Models\Tahapan;
use App\Models\Jaringan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravolt\Indonesia\Models\Province;

class JaringanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index(Request $request)
{
    $search = $request->input('search');
    $tahun = $request->input('tahun');
    $satker = $request->input('satker');

    // Query dengan kondisi pencarian
    $query = Jaringan::query();

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('latitude', 'like', "%{$search}%")
              ->orWhere('longitude', 'like', "%{$search}%")
              ->orWhereHas('province', function($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              })
              ->orWhereHas('city', function($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              })
              ->orWhereHas('district', function($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              })
              ->orWhereHas('village', function($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              });
        });
    }

    if ($tahun) {
        $query->where('tahun', $tahun);
    }

    if ($satker) {
        $query->where('satker', $satker);
    }

    $jaringans = $query->paginate(10)->appends($request->query());

    return view('jaringan.index', compact('jaringans', 'search', 'tahun', 'satker'));
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = Province::all();
        return view('jaringan.create', compact('provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'wilayah_sungai' => 'required',
            'jenis' => 'required',
            'tahun' => 'required',
            'satker' => 'required',
        ]);
        
        Jaringan::create($validateData);
        return redirect()->route('jaringan-atab.index')->with('success', 'Jaringan Telah Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\jaringan  $jaringan
     * @return \Illuminate\Http\Response
     */
    public function show(Jaringan $jaringan)
    {
        $tahapanPembentukanTim = Tahapan::where('jaringan_id', $jaringan->id)
            ->where('nama_tahapan', 'Pembentukan Tim')
            ->first();

        return view('jaringan.show', compact('jaringan', 'tahapanPembentukanTim'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\jaringan  $jaringan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jaringan $jaringan)
    {
        //dd($jaringan);
        $provinces = Province::all();
        return view('jaringan.edit', compact('jaringan', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\jaringan  $jaringan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jaringan $jaringan)
    {
        $validateData = $request->validate([
            'nama' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'wilayah_sungai' => 'required',
            'jenis' => 'required',
            'tahun' => 'required',
            'satker' => 'required',
        ]);
        
        $jaringan->update($validateData);
        return redirect()->route('jaringan-atab.index')->with('success', 'Jaringan Telah Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\jaringan  $jaringan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jaringan $jaringan)
    {
        // Hapus file terkait dari storage
        foreach ($jaringan->tahapans as $tahapan) {
            foreach ($tahapan->dokumens as $dokumen) {
                if (Storage::exists($dokumen->path_dokumen)) {
                    Storage::delete($dokumen->path_dokumen);
                }
            }
        }

        // Hapus data jaringan dan data terkait di tabel tahapan dan dokumen
        $jaringan->tahapans()->each(function ($tahapan) {
            $tahapan->dokumens()->delete();
        });
        $jaringan->tahapans()->delete();
        $jaringan->delete();

        return redirect()->route('jaringan-atab.index')->with('success', 'Jaringan Telah Dihapus beserta dokumen terkait.');
    }
    

    //------------------------------------CONTROLLER PROSES POP---------------------------------------------------------//
    public function pembentukanTimContent(Jaringan $jaringan)
    {   
        return view('tahapans.pembentukan_tim');
    }

 public function pembentukanTim(Request $request, Jaringan $jaringan)
    {
        $request->validate([
            'sk_tim_pembina' => 'required|file|mimes:pdf|max:3072',  // Max size 3MB
            'sk_tim_pelaksana' => 'required|file|mimes:pdf|max:3072', // Max size 3MB
        ]);

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Pembentukan Tim')->first();

        $file1 = $request->file('sk_tim_pembina')->storeAs('public/pembentukan_tim', uniqid() . '.' . $request->file('sk_tim_pembina')->getClientOriginalExtension());
        $file2 = $request->file('sk_tim_pelaksana')->storeAs('public/pembentukan_tim', uniqid() . '.' . $request->file('sk_tim_pelaksana')->getClientOriginalExtension());

        Dokumen::create([
            'tahapan_id' => $tahapan->id,
            'nama_dokumen' => 'SK Tim Pembina',
            'path_dokumen' => $file1,
        ]);

        Dokumen::create([
            'tahapan_id' => $tahapan->id,
            'nama_dokumen' => 'SK Tim Pelaksana',
            'path_dokumen' => $file2,
        ]);

         // Update tahapan di jaringan
        $jaringan->update(['tahapan' => 'Pembentukan Tim']);

        return response()->json(['success' => true]);
    }

    public function updatePembentukanTim(Request $request, Jaringan $jaringan)
    {
        $request->validate([
            'sk_tim_pembina' => 'file|mimes:pdf|max:3072',
            'sk_tim_pelaksana' => 'file|mimes:pdf|max:3072',
        ]);

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Pembentukan Tim')->first();

        if ($request->hasFile('sk_tim_pembina')) {
            $file1 = $request->file('sk_tim_pembina')->storeAs('public/pembentukan_tim', uniqid() . '.' . $request->file('sk_tim_pembina')->getClientOriginalExtension());
            Dokumen::updateOrCreate(
                ['tahapan_id' => $tahapan->id, 'nama_dokumen' => 'SK Tim Pembina'],
                ['path_dokumen' => $file1]
            );
        }

        if ($request->hasFile('sk_tim_pelaksana')) {
            $file2 = $request->file('sk_tim_pelaksana')->storeAs('public/pembentukan_tim', uniqid() . '.' . $request->file('sk_tim_pelaksana')->getClientOriginalExtension());
            Dokumen::updateOrCreate(
                ['tahapan_id' => $tahapan->id, 'nama_dokumen' => 'SK Tim Pelaksana'],
                ['path_dokumen' => $file2]
            );
        }

        return response()->json(['success' => 'Dokumen Pembentukan Tim berhasil diupdate.']);
    }



    
    public function penyusunanRencanaKerja(Request $request, Jaringan $jaringan)
    {
        $request->validate([
            'penyusunan_rencana_kerja' => 'required|file|mimes:pdf|max:3072', // Max size 3MB
        ]);

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Penyusunan Rencana Kerja')->first();

        $file = $request->file('penyusunan_rencana_kerja')->storeAs('public/penyusunan_rencana_kerja', uniqid() . '.' . $request->file('penyusunan_rencana_kerja')->getClientOriginalExtension());

        Dokumen::create([
            'tahapan_id' => $tahapan->id,
            'nama_dokumen' => 'Penyusunan Rencana Kerja',
            'path_dokumen' => $file,
        ]);

         // Update tahapan di jaringan
        $jaringan->update(['tahapan' => 'Penyusunan Rencana Kerja']);

        return response()->json(['success' => true]);
    }

    public function updatePenyusunanRencanaKerja(Request $request, Jaringan $jaringan)
    {
        $request->validate([
            'penyusunan_rencana_kerja' => 'file|mimes:pdf|max:3072',
        ]);

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Penyusunan Rencana Kerja')->first();

        if ($request->hasFile('penyusunan_rencana_kerja')) {
            $file = $request->file('penyusunan_rencana_kerja')->store('public/penyusunan_rencana_kerja');
            Dokumen::updateOrCreate(
                ['tahapan_id' => $tahapan->id, 'nama_dokumen' => 'Penyusunan Rencana Kerja'],
                ['path_dokumen' => $file]
            );
        }

        return response()->json(['success' => 'Dokumen Penyusunan Rencana Kerja berhasil diupdate.']);
    }

    public function sosialisasiKoordinasi(Request $request, Jaringan $jaringan)
    {
        $request->validate([
            'dokumen_sosialisasi' => 'required|file|mimes:pdf|max:3072',
        ]);

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Sosialisasi dan Koordinasi')->first();

        $file = $request->file('dokumen_sosialisasi')->storeAs('public/sosialisasi_dan_koordinasi', uniqid() . '.' . $request->file('dokumen_sosialisasi')->getClientOriginalExtension());

        Dokumen::create([
            'tahapan_id' => $tahapan->id,
            'nama_dokumen' => 'Sosialisasi dan Koordinasi',
            'path_dokumen' => $file,
        ]);

         // Update tahapan di jaringan
        $jaringan->update(['tahapan' => 'Sosialisasi dan Koordinasi']);

        return response()->json(['success' => true]);
    }

    public function updateSosialisasiKoordinasi(Request $request, Jaringan $jaringan)
    {
        $request->validate([
            'dokumen_sosialisasi' => 'file|mimes:pdf|max:3072',
        ]);

        $tahapan = $jaringan->tahapans()->where('nama_tahapan', 'Sosialisasi dan Koordinasi')->first();

        if ($request->hasFile('dokumen_sosialisasi')) {
            $file = $request->file('dokumen_sosialisasi')->storeAs('public/sosialisasi_dan_koordinasi', uniqid() . '.' . $request->file('dokumen_sosialisasi')->getClientOriginalExtension());
            Dokumen::updateOrCreate(
                ['tahapan_id' => $tahapan->id, 'nama_dokumen' => 'Sosialisasi dan Koordinasi'],
                ['path_dokumen' => $file]
            );
        }

        return response()->json(['success' => 'Dokumen Sosialisasi dan Koordinasi berhasil diupdate.']);
    }

}
