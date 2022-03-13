<?php

namespace App\Models;



use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class JfUserIntention extends Model
{



    protected $table = 'jf_user_intention';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

}
