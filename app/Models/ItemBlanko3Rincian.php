<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemBlanko3Rincian extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'item_blanko3_rincians';

    public function itemBlanko3()
    {
        return $this->belongsTo(ItemBlanko3::class, 'item_blanko3_id');
    }
}
