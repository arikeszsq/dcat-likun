<?php

namespace App\Models;



use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TuokecmaOption extends Model
{



    protected $table = 'jf_tuokecma_option';



    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }

}
