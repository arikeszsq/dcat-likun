<?php

namespace App\Admin\Controllers;

use App\Models\WebSetting;
use App\Traits\UserTrait;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;

class WebSettingController extends AdminController
{
    use UserTrait;

    public $title = '基础配置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new WebSetting(), function (Grid $grid) {

            if (!self::isSuperAdmin()) {
                $grid->model()->where('web_id', static::webId());
                if (!self::isWebAdmin()) {
                    $grid->model()->where('user_id', static::userId());
                }
            }
            $grid->model()->orderBy('id', 'desc');

            $grid->column('rolling', '响铃挂断时间（秒）');
            $grid->column('valid_phone', '有效时间');
            $grid->column('protect_day', '防骚扰(次/日)');
            $grid->column('protect_week', '防骚扰(周/日)');
            $grid->column('protect_month', '防骚扰(月/日)');
            $grid->column('next_num', '每张卡使用次数后切换');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new WebSetting(), function (Show $show) {
            $show->field('rolling', '响铃挂断时间（秒）');
            $show->field('valid_phone', '有效时间');
            $show->field('protect_day', '防骚扰(次/日)');
            $show->field('protect_week', '防骚扰(周/日)');
            $show->field('protect_month', '防骚扰(月/日)');
            $show->field('next_num', '每张卡使用次数后切换');
            $show->field('created_at', '创建时间');
            $show->field('updated_at', '更新时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new WebSetting(), function (Form $form) {

            $form->number('rolling', '响铃挂断时间（秒）');
            $form->number('valid_phone', '有效时间');
            $form->number('protect_day', '防骚扰(次/日)');
            $form->number('protect_week', '防骚扰(周/日)');
            $form->number('protect_month', '防骚扰(月/日)');
            $form->number('next_num', '每张卡使用次数后切换');

            $form->hidden('created_at');
            $form->hidden('updated_at');
            $form->hidden('web_id');
            $form->hidden('user_id');
            $form->saving(function (Form $form) {
                if ($form->isCreating()) {
                    $form->created_at = date('Y-m-d H:i:s');
                    $form->web_id = self::webId();
                    $form->user_id = self::userId();
                } else {
                    $form->updated_at = date('Y-m-d H:i:s');
                }
            });


            $form->saved(function (Form $form) {
                if ($form->isCreating()) {
                    $newId = $form->getKey();
                    if (!$newId) {
                        return $form->error('数据保存失败');
                    }
                    WebSetting::query()->where('web_id', self::webId())
                        ->where('id', '<', $newId)
                        ->delete();
                    return;
                }
            });
        });
    }
}
