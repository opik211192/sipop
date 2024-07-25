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
        
        // Query dengan kondisi pencarian
        $query = Jaringan::query();

        if ($search) {
            $query->where('nama', 'like', "%{$search}%")
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
        }

        $jaringan = $query->paginate(10);

        return view('jaringan.index', compact('jaringan', 'search'));
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
        ]);
        
        Jaringan::create($validateData);
        return redirect()->route('jaringan.index')->with('success', 'Jaringan Telah Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\jaringan  $jaringan
     * @return \Illuminate\Http\Response
     */
    public function show(Jaringan $jaringan)
    {
        
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
        ]);
        
        $jaringan->update($validateData);
        return redirect()->route('jaringan.index')->with('success', 'Jaringan Telah Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\jaringan  $jaringan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jaringan $jaringan)
    {
        //
    }
}
