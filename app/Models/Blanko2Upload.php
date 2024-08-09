<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blanko2Upload extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function itemBlanko()
    {
        return $this->belongsTo(ItemBlanko::class);
    }
}
