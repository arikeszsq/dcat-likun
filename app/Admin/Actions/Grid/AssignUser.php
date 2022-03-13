<?php

namespace App\Admin\Actions\Grid;

use App\Models\AdminUser;
use App\Traits\UserTrait;
use Dcat\Admin\Grid\BatchAction;
use Dcat\Admin\Widgets\Modal;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AssignUser extends BatchAction
{
    use UserTrait;
    /**
     * @return string
     */
    protected $title = '分配用户';


    public function render()
    {
        // 实例化表单类
        $form = \App\Admin\Forms\AssignUser::make();
        return Modal::make()
            ->lg()
            ->title($this->title)
            ->body($form)
            // 因为此处使用了表单异步加载功能，所以一定要用 onLoad 方法
            // 如果是非异步方式加载表单，则需要改成 onShow 方法
            ->onShow($this->getModalScript())
            ->button($this->title);
    }

    protected function getModalScript()
    {
        // 弹窗显示后往隐藏的id表单中写入批量选中的行ID
        return <<<JS
// 获取选中的ID数组
var key = {$this->getSelectedKeysScript()}

$('#reset-password-id').val(key);
JS;
    }
}
