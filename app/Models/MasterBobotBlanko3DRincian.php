<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBobotBlanko3DRincian extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'master_bobot_blanko_3d_rincian';

    public function masterBobotBlanko3D()
    {
        return $this->belongsTo(MasterBobotBlanko3D::class, 'master_bobot_blanko_3d_id');
    }
}
