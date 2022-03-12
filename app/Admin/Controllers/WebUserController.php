<?php

namespace App\Admin\Controllers;


use App\Models\Web;
use App\Traits\UserTrait;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WebUserController extends AdminController
{
    use UserTrait;

    protected $title = '站点管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Web(), function (Grid $grid) {
            $grid->model()->where('admin_role_id', 3);
            $grid->model()->where('web_id', static::webId());
            $grid->model()->where('id', '>', static::userId());
            $grid->column('id')->sortable();
            $grid->column('web_name', '站点名称');
            $grid->column('username');
            $grid->column('name');
            $grid->column('created_at');
            $grid->disableViewButton();
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Web(), function (Form $form) {
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
            });
            $form->text('username', '用户名');
            $form->text('name', '姓名');
            $form->image('avatar', '头像')->autoUpload();;
            $form->password('password', trans('admin.password'))
                ->minLength(5)
                ->maxLength(20)
                ->customFormat(function ($v) {
                    if ($v == $this->password) {
                        return;
                    }
                    return $v;
                });
            $form->password('password_confirmation', trans('admin.password_confirmation'))->same('password');
            $form->ignore(['password_confirmation', 'old_password']);

            $form->hidden('created_at');
            $form->hidden('updated_at');
            $form->hidden('admin_role_id');
            $form->hidden('web_id');
            $form->hidden('is_web_super');
            $form->hidden('web_name');

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
                if (!$form->password) {
                    $form->deleteInput('password');
                }
                if ($form->isCreating()) {
                    $user_name = $form->username;
                    $admin_exsit = Web::query()->where('username', $user_name)->first();
                    if ($admin_exsit) {
                        admin_toastr('用户名已存在，请换一个新的用户名', 'error');
                        return admin_redirect('web-users');
                    }

                    $form->created_at = date('Y-m-d H:i:s', time());
                    $form->admin_role_id = 3;
                    $form->web_id = self::webId();
                    $form->is_web_super = 2;
                    $form->web_name = self::user()->web_name;
                } else {
                    $form->updated_at = date('Y-m-d H:i:s', time());
                }
            });

            $form->saved(function (Form $form) {

                if ($form->isCreating()) {
                    $newId = $form->getKey();
                    if (!$newId) {
                        return $form->error('数据保存失败');
                    }
                    DB::table('admin_role_users')->insert([
                        'role_id' => 3,
                        'user_id' => $newId,
                        'created_at' => date('Y-m-d H:i:s', time()),
                        'updated_at' => date('Y-m-d H:i:s', time()),
                    ]);
                    return;
                }
            });


        });
    }
}
