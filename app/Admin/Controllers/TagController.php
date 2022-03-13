<?php

namespace App\Admin\Controllers;

use App\Models\Tag;
use App\Traits\UserTrait;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class TagController extends AdminController
{
    use UserTrait;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Tag(), function (Grid $grid) {

            if (!self::isSuperAdmin()) {
                $grid->model()->where('web_id', static::webId());
                if (!self::isWebAdmin()) {
                    $grid->model()->where('user_id', static::userId());
                }
            }
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id', __('Id'))->sortable();

            $grid->column('name','名称');
            $grid->column('description','描述');
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
        return Show::make($id, new Tag(), function (Show $show) {
            $show->field('id');
            $show->field('name','名称');
            $show->field('description','描述');
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
        return Form::make(new Tag(), function (Form $form) {
            $form->display('id');
            $form->text('name','名称');
            $form->text('description','描述');


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
