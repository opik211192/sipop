<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JaringanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
         return [
            'id' => $this->id,
            'nama_paket' => $this->nama,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'provinsi' => ucwords(strtolower($this->province->name)),
            'kota' => ucwords(strtolower($this->city->name)),
            'kecamatan' => ucwords(strtolower($this->district->name)),
            'desa' => ucwords(strtolower($this->village->name)),
            'wilayah_sungai' => $this->wilayah_sungai,
            'jenis' => $this->jenis,
            'tahun' => $this->tahun,
            'satker' => $this->satker,
            'tahapan' => $this->tahapan ?? 'Belum Tahapan',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
