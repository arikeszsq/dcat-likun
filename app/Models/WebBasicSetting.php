<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebBasicSetting extends Model
{

    const Static_职位选项 = 1;

    protected $table = 'jf_web_basic_setting';

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public static function getJobRoleList($type)
    {
        return WebBasicSetting::query()->where('type', $type)->get();
    }

    public static function getJobRoleArray($type)
    {
        $list = self::getJobRoleList($type);
        $data = [];
        foreach ($list as $val) {
            $data[$val->value] = $val->name;
        }
        return $data;
    }

}
