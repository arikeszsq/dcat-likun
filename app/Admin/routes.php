<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    /** 站点管理员 **/
    $router->resource('webs', 'WebController');
    /** 平台用户 **/
    $router->resource('web-users', 'WebUserController');

    /** 拓客码选项 **/
    $router->resource('tuo-options', 'TuokecmaOptionController');

});
