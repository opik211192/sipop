<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
