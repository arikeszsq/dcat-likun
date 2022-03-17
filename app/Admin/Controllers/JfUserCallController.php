<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JfUserExcel;
use App\Models\Tag;
use App\Models\WebSetting;
use App\Traits\UserTrait;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Setting;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;


class JfUserCallController extends Controller
{
    use UserTrait;
    public $title = '';

    public function index(Content $content)
    {
        $setting = WebSetting::getSetting();
        if ($setting) {
            $roll_time = $setting->rolling;
            $valid_time = $setting->valid_phone;
            $next_num = $setting->next_num;
        } else {
            $roll_time = 0;
            $valid_time = 10;
            $next_num = 20;
        }

        $setting_data = [
            'rolling_time' => $roll_time,
            'valid_time' => $valid_time,
            'next_num' => $next_num,
        ];

        $web_id = static::webId();
        $user_id = static::userId();
        $users = JfUserExcel::query()
            ->where('web_id',$web_id)
            ->where('master_id',$user_id)
            ->orderBy('id', 'desc')
            ->limit(200)
            ->get();

        $data_tags = Tag::query()
            ->where('web_id', $web_id)
            ->orderBy('id', 'desc')
            ->limit(200)
            ->get();

        $tags = [];
        foreach ($data_tags as $tag) {
            $tags[] = [
                'id' => $tag->id,
                'name' => $tag->name,
            ];
        }

        $data = [];
        foreach ($users as $key => $user) {
            $data[] = [
                'key_id' => ($key + 1),
                'id' => $user->id,
                'user_id' => $user->user_id,
                'user_name' => $user->user_name,
                'mobile' => $user->mobile,
                'call_no' => $user->call_no,
                'company_name' => $user->company_name,
                'source' => $user->source,
            ];
        }
        return $content->body(view('user.call', [
            'users' => $data,
            'tags' => $tags,
            'rolling_time' => $roll_time,
            'valid_time' => $valid_time,
            'next_num' => $next_num,
        ]));
    }


}
