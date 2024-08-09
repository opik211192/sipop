<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBobotBlanko3B extends Model
{
    use HasFactory;

    protected $guarded = [];
     protected $table = 'master_bobot_blanko_3b';

    public function rincian()
    {
        return $this->hasMany(MasterBobotBlanko3BRincian::class, 'master_bobot_blanko_3b_id');
    }
}
