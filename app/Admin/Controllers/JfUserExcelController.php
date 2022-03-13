<?php

namespace App\Admin\Controllers;

use App\Models\JfUserExcel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class JfUserExcelController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new JfUserExcel(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('web_id');
            $grid->column('user_id');
            $grid->column('master_id');
            $grid->column('company_name');
            $grid->column('user_name');
            $grid->column('mobile');
            $grid->column('status');
            $grid->column('call_no');
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
        return Show::make($id, new JfUserExcel(), function (Show $show) {
            $show->field('id');
            $show->field('web_id');
            $show->field('user_id');
            $show->field('master_id');
            $show->field('company_name');
            $show->field('user_name');
            $show->field('mobile');
            $show->field('status');
            $show->field('call_no');
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
        return Form::make(new JfUserExcel(), function (Form $form) {
            $form->display('id');
            $form->text('web_id');
            $form->text('user_id');
            $form->text('master_id');
            $form->text('company_name');
            $form->text('user_name');
            $form->text('mobile');
            $form->text('status');
            $form->text('call_no');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
