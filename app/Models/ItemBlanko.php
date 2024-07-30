<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemBlanko extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function evaluasiBlanko()
    {
        return $this->belongsTo(EvaluasiBlanko::class);
    }
}
