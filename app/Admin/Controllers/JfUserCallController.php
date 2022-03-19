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

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


class JfUserCallController extends Controller
{
    use UserTrait;
    public $title = '';

    public function index(Content $content, Request $request)
    {
        $setting = WebSetting::getSetting();
        if ($setting) {
            $roll_time = $setting->rolling;
            $valid_time = $setting->valid_phone;
            $next_num = $setting->next_num;
        } else {
            $roll_time = 30;
            $valid_time = 3;
            $next_num = 21;
        }

        $web_id = static::webId();
        $user_id = static::userId();

        $batch_lists = JfUserExcel::query()->select('batch_no')
            ->where('web_id', $web_id)
            ->where('master_id', $user_id)
            ->distinct('batch_no')
            ->get();
        $batch_array = [];
        foreach ($batch_lists as $list) {
            $batch_array[] = $list->batch_no;
        }

        $batch_no = $request->get('batch_no');
        if ($batch_no) {
            $users = JfUserExcel::query()
                ->where('web_id', $web_id)
                ->where('master_id', $user_id)
                ->where('batch_no', $batch_no)
                ->orderBy('id', 'desc')
                ->limit(200)
                ->get();
        } else {
            $users = JfUserExcel::query()
                ->where('web_id', $web_id)
                ->where('master_id', $user_id)
                ->orderBy('id', 'desc')
                ->limit(200)
                ->get();
        }

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
            'batch_array' => $batch_array,
        ]));
    }


}
