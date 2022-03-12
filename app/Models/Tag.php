<?php

namespace App\Models;

use App\Traits\UserTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{

    use UserTrait;

    protected $table = 'jf_web_tag';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public static function getTagList()
    {
        return Tag::query()->where('web_id', static::webId())->get();
    }

    public static function getTagArray()
    {
        $list = self::getTagList();
        $data = [];
        foreach ($list as $val) {
            $data[$val->id] = $val->name;
        }
        return $data;
    }
}
