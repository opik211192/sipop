<?php

namespace App\Http\Controllers;


use App\Models\Jaringan;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\District;
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
        return view('jaringan.show', compact('jaringan'));
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
        $jaringan->delete();
        return redirect()->route('jaringan-atab.index')->with('success', 'Jaringan Telah Dihapus');
    }
}
