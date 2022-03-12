<?php

namespace App\Models;



use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Web extends Model
{



    protected $table = 'admin_users';


    public $timestamps = false;

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }

}
