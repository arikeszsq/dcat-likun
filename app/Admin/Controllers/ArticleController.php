<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Repositories\Article;
use Dcat\Admin\Http\Controllers\AdminController;

class ArticleController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Article(), function (Grid $grid) {

            $grid->model()->orderBy('id', 'desc');

            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('type')->using(Article::TYPE_ARRAY);
            $grid->column('image')->image('', 60, 60);
            $grid->column('published_at');
            $grid->column('files')->view('admin.fields.files');
            $grid->column('status')->switch();
            $grid->column('created_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('type')->select(Article::TYPE_ARRAY);
                $filter->equal('status')->select(Article::STATUS_ARRAY);
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
        return Show::make($id, new Article(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('type')->using(Article::TYPE_ARRAY);
            $show->field('image')->image();
            $show->field('published_at');
            $show->field('content')->unescape();
            $show->field('files')->view('admin.fields.files');
            $show->field('status')->using(Article::STATUS_ARRAY);
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
        return Form::make(new Article(), function (Form $form) {
            $form->column(4, function (Form $form) {
                $form->text('title')->required();
                $form->select('type')->options(Article::TYPE_ARRAY)->required();
                $form->image('image')->move('article/images/' . date('Ymd'));
                $form->date('published_at');
                $form->multipleFile('files')->move('article/files/' . date('Ymd'));
                $form->switch('status')->default(1);
            });
            $form->column(8, function (Form $form) {
                $form->width(10,2)->editor('content')->required();
            });
        });
    }
}
