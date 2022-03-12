<?php

namespace App\Admin\Controllers;

use App\Models\Qcode;
use App\Models\TuokecmaOption;
use App\Models\Tuokema;
use App\Traits\UserTrait;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class TuokemaController extends AdminController
{
    use UserTrait;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Tuokema(), function (Grid $grid) {

            $grid->disableActions();// 禁用行操作

            if (!self::isSuperAdmin()) {
                $grid->model()->where('web_id', static::webId());
                if (!self::isWebAdmin()) {
                    $grid->model()->where('user_id', static::userId());
                }
            }
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id', __('Id'))->sortable();

            $grid->column('title', '标题');
            $grid->column('qcode_pic', '进件二维码');
            $grid->column('qcode_pic_has_bg', '进件二维码');
            $grid->column('created_at', '创建时间');

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
        return Show::make($id, new Tuokema(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('scan_to_url');
            $show->field('qcode_pic')->image();
            $show->field('qcode_pic_has_bg')->image();
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Tuokema(), function (Form $form) {

            $options = TuokecmaOption::query()->where('web_id', static::webId())
                ->orderBy('id', 'desc')
                ->get();
            $directors = [];
            foreach ($options as $option) {
                $directors[$option->id] = $option->title;
            }

            $form->display('id');
            $form->text('title', '标题')->required();
            $form->select('option_id', '拓客模板')->options($directors)->required();

            $form->hidden('scan_to_url');
            $form->hidden('qcode_pic');
            $form->hidden('qcode_pic_has_bg');
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
                    $url = env('APP_URL') . '?type=1&id=' . $newId;
                    $new_tuoke = Tuokema::query()->find($newId);
                    $option_id = $new_tuoke->option_id;
                    $option = TuokecmaOption::query()->find($option_id);
                    $bg_url = $option->code_bg_img;

                    $form->model()->qcode_pic_has_bg = Qcode::qrcodeWithBg($url, $bg_url);
                    $form->model()->qcode_pic = Qcode::qrcode($url);
                    $form->model()->scan_to_url = $url;
                    $form->model()->save();
                }
            });
        });
    }
}
