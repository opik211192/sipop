<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBobotBlanko3CRincian extends Model
{
    use HasFactory;

    protected $guarded = [];
     protected $table = 'master_bobot_blanko_3c_rincian';

    public function masterBobotBlanko3C()
    {
        return $this->belongsTo(MasterBobotBlanko3C::class, 'master_bobot_blanko_3c_id');
    }
}
