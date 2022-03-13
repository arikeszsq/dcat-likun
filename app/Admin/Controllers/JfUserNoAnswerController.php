<?php

namespace App\Admin\Controllers;

use App\Models\JfUserNoAnswer;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class JfUserNoAnswerController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new JfUserNoAnswer(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('web_id');
            $grid->column('user_name');
            $grid->column('mobile');
            $grid->column('company_name');
            $grid->column('content');
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
        return Show::make($id, new JfUserNoAnswer(), function (Show $show) {
            $show->field('id');
            $show->field('web_id');
            $show->field('user_name');
            $show->field('mobile');
            $show->field('company_name');
            $show->field('content');
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
        return Form::make(new JfUserNoAnswer(), function (Form $form) {
            $form->display('id');
            $form->text('web_id');
            $form->text('user_name');
            $form->text('mobile');
            $form->text('company_name');
            $form->text('content');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
