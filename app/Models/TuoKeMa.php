<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class TuoKeMa extends Model
{
    protected $table = 'jf_tuokema';

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }
}
