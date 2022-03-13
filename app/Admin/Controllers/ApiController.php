<?php

namespace App\Admin\Controllers;


use App\Models\JfUserExcel;
use App\Models\JfUserIntention;
use App\Traits\ResponseTrait;
use App\Traits\UserTrait;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends AdminController
{
    use UserTrait, ResponseTrait;

    public function addIntentionUser(Request $request)
    {
        $inputs = $request->all();
        $user_id = static::userId();
        $web_id = static::webId();
        $data = [
            'web_id' => $web_id,
            'user_id' => $user_id,
            'master_Id' => $user_id,
            'company_name' => isset($inputs['company_name']) && $inputs['company_name'] ? $inputs['company_name'] : '',
            'user_name' => isset($inputs['user_name']) && $inputs['user_name'] ? $inputs['user_name'] : '',
            'mobile' => isset($inputs['mobile']) && $inputs['mobile'] ? $inputs['mobile'] : '',
            'type' => isset($inputs['type']) && $inputs['type'] ? $inputs['type'] : '',
            'bak' => isset($inputs['bak']) && $inputs['bak'] ? $inputs['bak'] : '',
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        try {
            $ret = JfUserIntention::query()->insert($data);
            return self::success($ret);
        } catch (\Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }

    public function addUserCallRB(Request $request)
    {
        $inputs = $request->all();
        $id = $inputs['id'];
        $cdr = $inputs['cdr'];
        //        $cdr = "[Succeeded|CallNumber:18115676166|CallTime:|TalkTime:00:00:08|Key:|ClientOnHook|CCID:89860319945125379324]";
        $cdr_array = explode('|', $this->cut('[', ']', $cdr));
        $mobile = 0;
        $talk_time = 0;
        foreach ($cdr_array as $v) {
            if (strpos($v, 'CallNumber') !== false) {
                $mobile = $this->toArrayCut($v, ':');
            }
            if (strpos($v, 'TalkTime') !== false) {
                $time = mb_substr($v, 9);
                $time_array = explode(':', $time);
                $talk_time = $time_array[0] * 3600 + $time_array[1] * 60 + $time_array[2];
            }
        }
        $table_name = isset($inputs['table_name']) && $inputs['table_name'] ? $inputs['table_name'] : '';
        if ($table_name) {
            if ($mobile) {
                $data = [
                    'mobile' => $mobile,
                    'talk_time' => $talk_time,
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ];
                DB::table('jf_talk_log')->where('excel_user_id', $id)
                    ->where('table_name', $table_name)
                    ->orderBy('id', 'desc')
                    ->limit(1)
                    ->update($data);
            }
        } else {
            $user_excel = JfUserExcel::query()->find($id);
            $user_excel->call_no += 1;
            $user_excel->save();
            if ($mobile) {
                $data = [
                    'mobile' => $mobile,
                    'talk_time' => $talk_time,
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ];
                DB::table('jf_talk_log')->where('excel_user_id', $id)
                    ->where('table_name', 'jf_user_excel')
                    ->orderBy('id', 'desc')
                    ->limit(1)
                    ->update($data);
            }
        }
    }

    function cut($begin, $end, $str)
    {
        $b = mb_strpos($str, $begin) + mb_strlen($begin);
        $e = mb_strpos($str, $end) - $b;
        return mb_substr($str, $b, $e);
    }

    function toArrayCut($str, $string)
    {
        $array = explode($string, $str);
        if (isset($array[1]) && $array[1]) {
            return $array[1];
        } else {
            return 0;
        }
    }

    public function addUserCallRecord(Request $request)
    {
        $inputs = $request->all();
        $id = $inputs['id'];
        $record = $inputs['record'];
        $user_id = static::userId();
        $web_id = static::webId();
        $table_name = isset($inputs['table_name']) && $inputs['table_name'] ? $inputs['table_name'] : '';
        if (!$table_name) {
            $table_name = 'jf_user_excel';
        }
        $user = DB::table($table_name)->where('id', $id)->first();
        $data = [
            'web_id' => $web_id,
            'user_id' => $user_id,
            'user_name' => $user->user_name,
            'mobile'=>$user->mobile,
            'created_at' => date('Y-m-d H:i:s', time()),
            'table_id' => $id,
            'table_name' => $table_name,
            'record_url' => env('QINIU_YUMING') . '/' . $record . '.mp3'
        ];
        DB::table('jf_talk_log')->insert($data);
    }
}