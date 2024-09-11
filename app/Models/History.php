<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'jaringan_id',
        'tahapan_id',
        'tanggal',
        'data',
        'recommendation',
    ];

    // Cast the data field to array automatically
    protected $casts = [
        'data' => 'array',
    ];

    // Relationship with Jaringan
    public function jaringan()
    {
        return $this->belongsTo(Jaringan::class);
    }

     // Relationship with Tahapan
    public function tahapan()
    {
        return $this->belongsTo(Tahapan::class);
    }

}
