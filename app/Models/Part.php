<?php

namespace App\Models;


use App\Traits\UserTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{

    use UserTrait;


    protected $table = 'jf_web_part';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public static function getPartList()
    {
        return self::query()->where('web_id', static::webId())->get();
    }

    public static function getPartArray()
    {
        $list = self::getPartList();
        $data = [];
        foreach ($list as $val) {
            $data[$val->id] = $val->name;
        }
        return $data;
    }

}
