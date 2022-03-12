<?php

namespace App\Company\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Admin;
use App\Repositories\Company;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Grid\Displayers\Actions;
use Dcat\Admin\Http\Controllers\AdminController;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class InfoController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Company(), function (Grid $grid) {

            $grid->disableCreateButton();

            $grid->model()->where('id', Admin::user()->company->id);

            $grid->disableFilter();
            $grid->column('name');
            $grid->column('area')->using(Company::AREA_ARRAY);
            $grid->column('nation')->using(Company::NATION_ARRAY);
            $grid->column('industry')->using(Company::INDUSTRY_ARRAY);
            $grid->column('type')->using(Company::TYPE_ARRAY);
            $grid->column('capital')->using(Company::CAPITAL_ARRAY);
            $grid->column('staff')->using(Company::STAFF_ARRAY);
            $grid->column('contact');
            $grid->column('telephone');
            $grid->column('address');
            $grid->column('license')->downloadable();
            $grid->column('status')->using(Company::STATUS);

            $grid->actions(function (Actions $actions) {
                $actions->disableDelete();
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


    public function create(Content $content)
    {
        throw new UnauthorizedHttpException('', '您没有权限进行此操作');
    }

    public function edit($id, Content $content)
    {
        if (Admin::user()->company->id != $id) {
            throw new UnauthorizedHttpException('', '您没有权限进行此操作');
        }
        return parent::edit($id, $content);
    }

    public function show($id, Content $content)
    {
        if (Admin::user()->company->id != $id) {
            throw new UnauthorizedHttpException('', '您没有权限进行此操作');
        }
        return parent::edit($id, $content);
    }
}
