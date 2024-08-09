<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBobotBlanko3D extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'master_bobot_blanko_3d';

     public function rincian()
    {
        return $this->hasMany(MasterBobotBlanko3DRincian::class, 'master_bobot_blanko_3d_id');
    }
}
