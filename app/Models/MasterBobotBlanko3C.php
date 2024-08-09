<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBobotBlanko3C extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'master_bobot_blanko_3c';

        public function rincian()
    {
        return $this->hasMany(MasterBobotBlanko3CRincian::class, 'master_bobot_blanko_3c_id');
    }

}
