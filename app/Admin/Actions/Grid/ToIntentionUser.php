<?php

namespace App\Admin\Actions\Grid;

use App\Models\JfUserIntention;
use App\Models\JfUserPersonal;
use App\Models\JfUserPublic;
use App\Traits\UserTrait;
use Dcat\Admin\Grid\BatchAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToIntentionUser extends BatchAction
{
    use UserTrait;
    /**
     * @return string
     */
    protected $title = '转为意向客户';


    // 确认弹窗信息
    public function confirm()
    {
        return '您确定转为意向客户吗？';
    }

    // 处理请求
    public function handle(Request $request)
    {
        // 获取选中的文章ID数组
        $keys = $this->getKey();

        $data = [];
        foreach ($keys as $user_id) {
            $pub_user = JfUserPersonal::query()->find($user_id);
            $data[] = [
                'web_id' => self::webId(),
                'user_id' => self::userId(),
                'master_id' => self::userId(),
                'user_name' => $pub_user->user_name,
                'mobile' => $pub_user->mobile,
                'company_name' => $pub_user->company_name,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
                'source' => $pub_user->source,
            ];
            JfUserPersonal::query()->where('id', $user_id)->delete();
        }
        DB::table('jf_user_intention')->insert($data);
        $message = '成功转为意向客户';
        return $this->response()->success($message)->refresh();
    }

}
