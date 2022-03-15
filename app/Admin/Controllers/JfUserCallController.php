<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JfUserExcel;
use App\Models\Tag;
use App\Traits\UserTrait;
use Dcat\Admin\Layout\Content;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;


class JfUserCallController extends Controller
{
    use UserTrait;
    public $title = '';

    public function index(Content $content)
    {
        //存入redis
        Redis::set('key','value');

        Redis::incr('no');
//取出
        $value = Redis::get('no');
        var_dump($value);exit;
        $web_id = static::webId();
        $user_id = static::userId();
        $users = JfUserExcel::query()
//            ->where('web_id',$web_id)
//            ->where('master_id',$user_id)
//            ->where('call_no', 0)
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
        return $content->body(view('user.call', ['users' => $data, 'tags' => $tags]));
    }


}
