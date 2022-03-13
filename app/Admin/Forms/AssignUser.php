<?php

namespace App\Admin\Forms;

use App\Models\AdminUser;
use App\Models\JfUserExcel;
use App\Traits\UserTrait;
use Dcat\Admin\Widgets\Form;

class AssignUser extends Form
{
    use UserTrait;

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        $master_id = $input['master_id'];
        if (!$master_id) {
            return $this->response()->error('请选择接收数据的用户');
        }
        // id : 1,2,3
        $id = $input['id'];
        if (!$id) {
            return $this->response()->error('请选择需要分配的资源');
        }

        $id_array = explode(',', $input['id']);

        JfUserExcel::query()->whereIn('id', $id_array)->update([
            'master_id' => $master_id,
            'updated_at' => date('Y-m-d H:i:s', time())
        ]);
        return $this
            ->response()
            ->success('分配用户成功')
            ->refresh();
    }

    public function initPayload()
    {
        parent::initPayload(); // TODO: Change the autogenerated stub
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $users = AdminUser::query()->where('web_id', static::webId())
            ->orderBy('id', 'desc')
            ->get();
        $options = [];
        foreach ($users as $user) {
            $options[$user->id] = $user->username;
        }
        $this->select('master_id', '用户')->options($options)->required();

        // 设置隐藏表单，传递用户id
        $this->hidden('id')->attribute('id', 'reset-password-id');
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [
        ];
    }
}
