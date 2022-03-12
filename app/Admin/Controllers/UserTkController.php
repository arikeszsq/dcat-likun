<?php

namespace App\Admin\Controllers;

use App\Models\UserTk;
use App\Traits\UserTrait;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserTkController extends AdminController
{
    use UserTrait;

    public $title = '客户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new UserTk(), function (Grid $grid) {

            if (!self::isSuperAdmin()) {
                $grid->model()->where('web_id', static::webId());
                if (!self::isWebAdmin()) {
                    $grid->model()->where('user_id', static::userId());
                }
            }
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id', __('Id'))->sortable();

            $grid->column('company_name');
            $grid->column('user_name');
            $grid->column('mobile');
            $grid->column('created_at');

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
        return Show::make($id, new UserTk(), function (Show $show) {
            $show->field('company_name');
            $show->field('user_name');
            $show->field('mobile');
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
        return Form::make(new UserTk(), function (Form $form) {
            $form->display('id');
            $form->text('company_name');
            $form->text('user_name');
            $form->mobile('mobile');
            $form->textarea('bak');

            $form->display('created_at');
            $form->display('updated_at');

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
