<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBobotBlanko3BRincian extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'master_bobot_blanko_3b_rincian';
    
    public function masterBobotBlanko3B()
    {
        return $this->belongsTo(MasterBobotBlanko3B::class, 'master_bobot_blanko_3b_id');
    }
}
