<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBobotBlanko3ARincian extends Model
{
    use HasFactory;

    protected $guarded = [];
     protected $table = 'master_bobot_blanko_3a_rincian';

     public function masterBobotBlanko3A()
    {
        return $this->belongsTo(MasterBobotBlanko3A::class, 'master_bobot_blanko_3a_id');
    }
}
