<?php

namespace App\Admin\Controllers;

use App\Models\JfUserIntention;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class JfUserIntentionController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new JfUserIntention(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('web_id');
            $grid->column('user_id');
            $grid->column('master_Id');
            $grid->column('company_name');
            $grid->column('user_name');
            $grid->column('mobile');
            $grid->column('wechat');
            $grid->column('qq');
            $grid->column('type');
            $grid->column('status');
            $grid->column('bak');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
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
        return Show::make($id, new JfUserIntention(), function (Show $show) {
            $show->field('id');
            $show->field('web_id');
            $show->field('user_id');
            $show->field('master_Id');
            $show->field('company_name');
            $show->field('user_name');
            $show->field('mobile');
            $show->field('wechat');
            $show->field('qq');
            $show->field('type');
            $show->field('status');
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
        return Form::make(new JfUserIntention(), function (Form $form) {
            $form->display('id');
            $form->text('web_id');
            $form->text('user_id');
            $form->text('master_Id');
            $form->text('company_name');
            $form->text('user_name');
            $form->text('mobile');
            $form->text('wechat');
            $form->text('qq');
            $form->text('type');
            $form->text('status');
            $form->text('bak');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
