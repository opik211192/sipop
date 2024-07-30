<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluasiBlanko extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tahapan()
    {
        return $this->belongsTo(Tahapan::class);
    }

    public function items()
    {
        return $this->hasMany(ItemBlanko::class);
    }
}
