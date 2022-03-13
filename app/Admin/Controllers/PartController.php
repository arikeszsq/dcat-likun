<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Part;
use App\Traits\UserTrait;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class PartController extends AdminController
{
    use UserTrait;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Part(), function (Grid $grid) {


            if (!self::isSuperAdmin()) {
                $grid->model()->where('web_id', static::webId());
                if (!self::isWebAdmin()) {
                    $grid->model()->where('user_id', static::userId());
                }
            }
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id', __('Id'))->sortable();


            $grid->column('name','部门名称');
//            $grid->column('part_user_id','部门负责人');
            $grid->column('created_at','创建时间');
            $grid->column('updated_at','更新时间')->sortable();

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
        return Show::make($id, new Part(), function (Show $show) {
            $show->field('name','部门名称');
//            $show->field('part_user_id','部门负责人');
            $show->field('created_at','创建时间');
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
        return Form::make(new Part(), function (Form $form) {

            $form->text('name','部门名称');
//            $form->text('part_user_id');

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
