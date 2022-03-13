<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JfUserExcel;
use App\Traits\UserTrait;
use Dcat\Admin\Layout\Content;
use Illuminate\Http\Request;


class JfUserCallController extends Controller
{
    use UserTrait;
    public $title = '';


    public function index(Content $content)
    {
        $web_id = static::webId();
        $user_id = static::userId();
        $users = JfUserExcel::query()
//            ->where('web_id',$web_id)
//            ->where('master_id',$user_id)
//            ->where('call_no', 0)
            ->orderBy('id', 'desc')
            ->limit(200)
            ->get();

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
            ];
        }
        return $content->body(view('user.call',['users' => $data]));
    }


}
