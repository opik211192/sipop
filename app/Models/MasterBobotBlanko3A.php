<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBobotBlanko3A extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'master_bobot_blanko_3a';

    public function rincian()
    {
        return $this->hasMany(MasterBobotBlanko3ARincian::class, 'master_bobot_blanko_3a_id');
    }

    

}
