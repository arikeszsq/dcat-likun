<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\JfTalkLog;
use App\Traits\UserTrait;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class JfTalkLogController extends AdminController
{
    use UserTrait;
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new JfTalkLog(), function (Grid $grid) {

            if (!self::isSuperAdmin()) {
                $grid->model()->where('web_id', static::webId());
                if (!self::isWebAdmin()) {
                    $grid->model()->where('user_id', static::userId());
                }
            }
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id', __('Id'))->sortable();

            // 禁用创建按钮
            $grid->disableCreateButton();

            $grid->column('user_name','姓名');

//            $grid->column('table_name');
//            $grid->column('table_id');

            $grid->column('mobile','手机号');
            $grid->column('talk_time','通话时长（秒）');
            $grid->column('record_url','录音文件')->link();
            $grid->column('created_at','通话时间');

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
        return Show::make($id, new JfTalkLog(), function (Show $show) {
            $show->field('id');
            $show->field('user_name','姓名');
            $show->field('mobile','手机号');
            $show->field('talk_time','通话时长（秒）');
            $show->field('record_url','录音文件地址');
            $show->field('created_at','通话时间');
            $show->field('updated_at','更新时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new JfTalkLog(), function (Form $form) {
            $form->text('user_name');
        });
    }
}
