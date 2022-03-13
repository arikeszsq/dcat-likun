<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\AssignUser;
use App\Admin\Extensions\CheckRow;
use App\Models\JfUserExcel;
use App\Traits\UserTrait;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class JfUserExcelController extends AdminController
{
    use UserTrait;

    public $title='资源';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new JfUserExcel(), function (Grid $grid) {

            if (!self::isSuperAdmin()) {
                $grid->model()->where('web_id', static::webId());
                if (!self::isWebAdmin()) {
                    $grid->model()->where('master_id', static::userId());
                }
            }
            $grid->model()->orderBy('id', 'desc');
            $grid->column('id', __('Id'))->sortable();

            $grid->column('user_name','姓名');
            $grid->column('mobile','手机号');
            $grid->column('company_name','公司名称');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

            });

            $grid->batchActions([
                new AssignUser()
            ]);

            $grid->actions(function ($actions) {
                $actions->append(new CheckRow($actions->row,'jf_user_intention'));
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
            $show->field('user_name','姓名');
            $show->field('mobile','手机号');
            $show->field('company_name','公司名称');

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
            $form->text('company_name');
            $form->text('user_name');
            $form->text('mobile');
            $form->text('status');
            $form->text('call_no');

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
