<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\ResetCompanyPassword;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Repositories\Company;
use Dcat\Admin\Http\Controllers\AdminController;

class CompanyController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Company(), function (Grid $grid) {
            $grid->model()->with(['adminUser'])->orderBy('id', 'desc');

            $grid->showColumnSelector();

            $grid->disableCreateButton();

            $grid->export();

            $grid->column('name');
            $grid->column('adminUser.username', '登录账号名');
            $grid->column('area')->using(Company::AREA_ARRAY);
            $grid->column('nation')->using(Company::NATION_ARRAY)->hide();
            $grid->column('industry')->using(Company::INDUSTRY_ARRAY)->hide();
            $grid->column('type')->using(Company::TYPE_ARRAY)->hide();
            $grid->column('capital')->using(Company::CAPITAL_ARRAY)->hide();
            $grid->column('staff')->using(Company::STAFF_ARRAY)->hide();
            $grid->column('contact');
            $grid->column('telephone');
            $grid->column('address')->hide();
            $grid->column('license')->downloadable()->hide();
            $grid->column('status')->editable()->select(Company::STATUS);
            $grid->column('created_at')->sortable();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->append(new ResetCompanyPassword());
            });
            
            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('name');
                $filter->equal('area')->select(Company::AREA_ARRAY);
                $filter->equal('status')->select(Company::STATUS);
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
        return Show::make($id, new Company(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('area')->using(Company::AREA_ARRAY);
            $show->field('nation')->using(Company::NATION_ARRAY);
            $show->field('industry')->using(Company::INDUSTRY_ARRAY);
            $show->field('type')->using(Company::TYPE_ARRAY);
            $show->field('capital')->using(Company::CAPITAL_ARRAY);
            $show->field('staff')->using(Company::STAFF_ARRAY);
            $show->field('contact');
            $show->field('telephone');
            $show->field('address');
            $show->field('license')->file();
            $show->field('status')->using(Company::STATUS);
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
        return Form::make(new Company(), function (Form $form) {
            $form->display('name');
            $form->select('area')->required()->options(Company::AREA_ARRAY);
            $form->select('nation')->required()->options(Company::NATION_ARRAY);
            $form->select('industry')->required()->options(Company::INDUSTRY_ARRAY);
            $form->select('type')->required()->options(Company::TYPE_ARRAY);
            $form->select('capital')->required()->options(Company::CAPITAL_ARRAY);
            $form->select('staff')->required()->options(Company::STAFF_ARRAY);
            $form->text('contact')->required();
            $form->text('telephone')->required();
            $form->text('address')->required();
        });
    }
}
