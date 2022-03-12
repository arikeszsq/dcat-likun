<?php

namespace App\Admin\Controllers;

use App\Models\TuokecmaOption;
use App\Traits\UserTrait;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class TuokecmaOptionController extends AdminController
{
    use UserTrait;
    public $title='拓客模板';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TuokecmaOption(), function (Grid $grid) {

            $grid->model()->orderBy('id','desc');
            if (!self::isSuperAdmin()) {
                $grid->model()->where('web_id', static::webId());
            }
            $grid->column('id')->sortable();
            $grid->column('title');
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
        return Show::make($id, new TuokecmaOption(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('banner')->image();
            $show->field('code_bg_img')->image();
            $show->field('bak');
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
        return Form::make(new TuokecmaOption(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->image('banner');
            $form->image('code_bg_img');
            $form->textarea('bak');

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
        });
    }
}
