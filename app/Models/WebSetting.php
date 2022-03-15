<?php

namespace App\Models;



use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    use UserTrait;


    protected $table = 'jf_web_setting';


    public static function getSetting()
    {
        return self::query()->where('web_id',self::webId())
            ->orderBy('id','desc')
            ->first();
    }
}
