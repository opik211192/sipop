<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemBlanko3 extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'item_blanko3s';

    public function evaluasiBlanko()
    {
        return $this->belongsTo(EvaluasiBlanko::class);
    }

    public function rincians()
    {
        return $this->hasMany(ItemBlanko3Rincian::class, 'item_blanko3_id');
    }
}
