<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahapan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jaringan()
    {
        return $this->belongsTo(Jaringan::class);
    }

    public function evaluasiBlankos()
    {
        return $this->hasMany(EvaluasiBlanko::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }
}
