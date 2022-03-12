<?php

namespace App\Models;

use App\Traits\UserTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{

    use UserTrait;

    protected $table = 'jf_web_area';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public static function getAreaList()
    {
        return Area::query()->where('web_id', static::webId())->get();
    }

    public static function getAreaArray()
    {
        $list = self::getAreaList();
        $data = [];
        foreach ($list as $val) {
            $data[$val->id] = $val->name;
        }
        return $data;
    }
}
