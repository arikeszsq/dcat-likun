<?php

namespace App\Models;



use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class JfUserPersonal extends Model
{



    protected $table = 'jf_user_personal';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

}
