<?php

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Form\Field\Editor;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

 //把view目录从vendor中复制出来方便修改
app('view')->prependNamespace('admin', resource_path('views/person'));

Editor::resolving(function (Editor $editor) {

    // 设置编辑器图片默认上传服务和地址
    $editor->disk('person');

});
