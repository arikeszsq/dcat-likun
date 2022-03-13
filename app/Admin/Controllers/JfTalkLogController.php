<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\JfTalkLog;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class JfTalkLogController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new JfTalkLog(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('web_id');
            $grid->column('user_id');
            $grid->column('excel_user_name');
            $grid->column('excel_user_id');
            $grid->column('mobile');
            $grid->column('talk_time');
            $grid->column('record_url');
            $grid->column('table_name');
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
        return Show::make($id, new JfTalkLog(), function (Show $show) {
            $show->field('id');
            $show->field('web_id');
            $show->field('user_id');
            $show->field('excel_user_name');
            $show->field('excel_user_id');
            $show->field('mobile');
            $show->field('talk_time');
            $show->field('record_url');
            $show->field('table_name');
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
        return Form::make(new JfTalkLog(), function (Form $form) {
            $form->display('id');
            $form->text('web_id');
            $form->text('user_id');
            $form->text('excel_user_name');
            $form->text('excel_user_id');
            $form->text('mobile');
            $form->text('talk_time');
            $form->text('record_url');
            $form->text('table_name');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
