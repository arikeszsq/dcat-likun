<?php

namespace App\Admin\Controllers;


use App\Models\JfTalkLog;
use App\Models\JfUserExcel;
use App\Models\JfUserIntention;
use App\Models\JfUserNoAnswer;
use App\Models\JfUserPublic;
use App\Models\WebSetting;
use App\Traits\ResponseTrait;
use App\Traits\UserTrait;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ApiController extends AdminController
{
    use UserTrait, ResponseTrait;

    public function verifyMobile(Request $request)
    {
        //对redis设置 手机号key ,1天 ，7天和30天有效期的值
        $inputs = $request->all();
        $mobile = $inputs['mobile'];
        $setting = WebSetting::getSetting();
        if (!$setting) {
            $day_num = 2;
            $week_num = 7;
            $month_num = 30;
        } else {
            $day_num = $setting->protect_day;
            $week_num = $setting->protect_week;
            $month_num = $setting->protect_month;
        }
        $web_id = self::webId();

        $mobile_day = $mobile . $web_id;
        $mobile_week = $mobile . $web_id;
        $mobile_month = $mobile . $web_id;
        $day_redis_num = intval(Redis::get($mobile_day));
        $week_redis_num = intval(Redis::get($mobile_week));
        $month_redis_num = intval(Redis::get($mobile_month));

        if (!$day_redis_num) {
            Redis::set($mobile_day, 0);
            Redis::expire($mobile_day, 24 * 3600);
        }

        if (!$day_redis_num) {
            Redis::set($mobile_week, 0);
            Redis::expire($mobile_week, 24 * 3600 * 7);
        }

        if (!$day_redis_num) {
            Redis::set($mobile_month, 0);
            Redis::expire($mobile_month, 24 * 3600 * 30);
        }

        if ($day_redis_num > $day_num) {
            return self::fail('日呼叫防护');
        } else {
            Redis::incr($mobile_day);
        }
        if ($week_redis_num > $week_num) {
            return self::fail('周呼叫防护');
        } else {
            Redis::incr($mobile_week);
        }
        if ($month_redis_num > $month_num) {
            return self::fail('月呼叫防护');
        } else {
            Redis::incr($mobile_month);
        }
        return self::success();
    }

    public function addIntentionUser(Request $request)
    {
        $inputs = $request->all();
        $user_id = static::userId();
        $web_id = static::webId();
        $tag_id = [];
        if (isset($inputs['select_tag_ids']) && $inputs['select_tag_ids']) {
            $tag_ids = explode(',', $inputs['select_tag_ids']);
            foreach ($tag_ids as $id) {
                if ($id) {
                    $tag_id[] = $id;
                }
            }
        }
        $tag_id_string = json_encode($tag_id);
        $data = [
            'web_id' => $web_id,
            'user_id' => $user_id,
            'master_Id' => $user_id,
            'company_name' => isset($inputs['company_name']) && $inputs['company_name'] ? $inputs['company_name'] : '',
            'user_name' => isset($inputs['user_name']) && $inputs['user_name'] ? $inputs['user_name'] : '',
            'mobile' => isset($inputs['mobile']) && $inputs['mobile'] ? $inputs['mobile'] : '',
            'source' => isset($inputs['source']) && $inputs['source'] ? $inputs['source'] : '',
            'select_tag_ids' => $tag_id_string,
            'type' => isset($inputs['type']) && $inputs['type'] ? $inputs['type'] : '',
            'bak' => isset($inputs['bak']) && $inputs['bak'] ? $inputs['bak'] : '',
            'created_at' => date('Y-m-d H:i:s', time()),
        ];
        try {
            $ret = JfUserIntention::query()->insert($data);
            $excel_user_id = $inputs['excel_user_id'];
            JfUserExcel::query()->where('id', $excel_user_id)->delete();
            return self::success($ret);
        } catch (\Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }

    //只要拨打电话，就创建一条通话记录，无论拨通未拨通
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
        if ($user) {
            $data = [
                'web_id' => $web_id,
                'user_id' => $user_id,
                'company_name' => $user->company_name,
                'user_name' => $user->user_name,
                'mobile' => $user->mobile,
                'created_at' => date('Y-m-d H:i:s', time()),
                'table_id' => $id,
                'table_name' => $table_name,
                'record_url' => env('QINIU_YUMING') . '/' . $record . '.mp3'
            ];
        } else {
            $data = [
                'web_id' => $web_id,
                'user_id' => $user_id,
                'company_name' => '',
                'user_name' => '',
                'mobile' => '',
                'created_at' => date('Y-m-d H:i:s', time()),
                'table_id' => $id,
                'table_name' => $table_name,
                'record_url' => env('QINIU_YUMING') . '/' . $record . '.mp3'
            ];
        }

        DB::table('jf_talk_log')->insert($data);
    }

    //挂机之后，更新通话记录，通话时间等信息
    public function addUserCallRB(Request $request)
    {
        $inputs = $request->all();
        $user_id = static::userId();
        $web_id = static::webId();
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
                    'is_connect' => $talk_time == 0 ? 2 : 1,
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ];
                DB::table('jf_talk_log')->where('table_id', $id)
                    ->where('table_name', $table_name)
                    ->orderBy('id', 'desc')
                    ->limit(1)
                    ->update($data);
            }
        } else {
            //这里是资源库导入资源的操作
            if ($mobile) {
                $data = [
                    'mobile' => $mobile,
                    'talk_time' => $talk_time,
                    'is_connect' => $talk_time == 0 ? 2 : 1,
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ];
                JfTalkLog::query()->where('table_id', $id)
                    ->where('table_name', 'jf_user_excel')
                    ->orderBy('id', 'desc')
                    ->limit(1)
                    ->update($data);
            }
            if ($talk_time == 0) {
                //导入资源里，未接通的电话，会挪动到未接通表
                $user = JfUserExcel::query()->find($id);
                if ($user) {
                    $data = [
                        'web_id' => $web_id,
                        'user_id' => $user_id,
                        'master_id' => $user_id,
                        'user_name' => $user->user_name,
                        'company_name' => $user->company_name,
                        'mobile' => $user->mobile,
                        'source' => $user->source,
                        'created_at' => date('Y-m-d H:i:s', time())
                    ];
                    JfUserNoAnswer::query()->insert($data);
                    JfUserExcel::query()->where('id', $id)->delete();
                }
            } else {
                //有通话时间的，如果未转入意向客户，就转入公海
                $user = JfUserExcel::query()->find($id);
                if ($user) {
                    $data = [
                        'web_id' => $web_id,
                        'user_id' => $user_id,
                        'master_id' => $user_id,
                        'user_name' => $user->user_name,
                        'company_name' => $user->company_name,
                        'mobile' => $user->mobile,
                        'source' => $user->source,
                        'created_at' => date('Y-m-d H:i:s', time())
                    ];
                    JfUserPublic::query()->insert($data);
                    JfUserExcel::query()->where('id', $id)->delete();
                }
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

    public function searchData(Request $request)
    {
        $inputs = $request->all();
        $user_id = static::userId();
        $web_id = static::webId();
        $start_date = $inputs['start_date'];
        $end_date = $inputs['end_date'];
        if (!$start_date) {
            $start_date = date('Y-m-d 00:00:01', time());
        }
        if (!$end_date) {
            $end_date = date('Y-m-d 23:59:59', time());
        }
        if (strtotime($start_date) > strtotime($end_date)) {
            return self::fail([
                'code' => 3001,
                'msg' => '开始日期不能大于结束日期'
            ]);
        }

        $call_total = JfTalkLog::query()->where('user_id', $user_id)
            ->where('created_at', '>', $start_date)
            ->where('created_at', '<', $end_date)
            ->count();

        $talk_time = JfTalkLog::query()->where('user_id', $user_id)
            ->where('created_at', '>', $start_date)
            ->where('created_at', '<', $end_date)
            ->sum('talk_time');

        $new_intention = JfUserIntention::query()->where('user_id', $user_id)
            ->where('created_at', '>', $start_date)
            ->where('created_at', '<', $end_date)
            ->count();

        $no_num = JfTalkLog::query()->where('user_id', $user_id)
            ->where('is_connect', 2)
            ->where('created_at', '>', $start_date)
            ->where('created_at', '<', $end_date)
            ->count();

        $get_num = JfTalkLog::query()->where('user_id', $user_id)
            ->where('is_connect', 1)
            ->where('created_at', '>', $start_date)
            ->where('created_at', '<', $end_date)
            ->count();

        $setting = WebSetting::getSetting();
        $valid_time = isset($setting->valid_phone) && $setting->valid_phone ? $setting->valid_phone : 3;

        $valid_num = JfTalkLog::query()->where('user_id', $user_id)
            ->where('talk_time', '>=',$valid_time)
            ->where('created_at', '>', $start_date)
            ->where('created_at', '<', $end_date)
            ->count();

        $valid_long = JfTalkLog::query()->where('user_id', $user_id)
            ->where('talk_time', '>=',$valid_time)
            ->where('created_at', '>', $start_date)
            ->where('created_at', '<', $end_date)
            ->sum('talk_time');

        return self::success([
            'call_total' => $call_total,
            'talk_time' => $talk_time,
            'new_intention' => $new_intention,
            'no_num' => $no_num,
            'get_num' => $get_num,
            'valid_num' => $valid_num,
            'valid_long' => $valid_long,
            'start_date'=>date('Y-m-d',strtotime($start_date)),
            'end_date'=>date('Y-m-d',strtotime($end_date))
        ]);

    }
}
