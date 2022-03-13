<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    /** 站点管理员 **/
    $router->resource('webs', 'WebController');
    /** 平台用户 **/
    $router->resource('web-users', 'WebUserController');
    /** 平台大区管理 **/
    $router->resource('areas', 'AreaController');
    /** 平台部门管理 **/
    $router->resource('parts', 'PartController');
    /** 平台标签管理 **/
    $router->resource('tags', 'TagController');
    /** 基础配置 **/
    $router->resource('web-setting', 'WebSettingController');


    /** 拓客码选项 **/
    $router->resource('tuo-options', 'TuokecmaOptionController');
    /** 拓客码 **/
    $router->resource('tuo', 'TuokemaController');
    /** 拓客客户管理 **/
    $router->resource('tuo-users', 'UserTkController');


    /** 资源库，资源导入 **/
    $router->resource('user-excels', 'JfUserExcelController');
    /** 资源库，呼叫系统 **/
    $router->resource('user-call', 'JfUserCallController');
    /** 资源库，意向客户 **/
    $router->resource('user-intentions', 'JfUserIntentionController');
    /** 资源库，电话记录 **/
    $router->resource('user-talk-logs', 'JfTalkLogController');
    /** 资源库，公海 **/
    $router->resource('user-public', 'JfUserPublicController');
    /** 资源库，个人资源 **/
    $router->resource('user-personal', 'JfUserPersonalController');
    /** 资源库，未接通客户 **/
    $router->resource('user-no-answer', 'JfUserNoAnswerController');


    /** 以下接口 ，记得 1.需要去系统添加权限 2.需要在middleware添加白名单 **/
    Route::any('/add-intention', 'ApiController@addIntentionUser');
    Route::any('/call-back', 'ApiController@addUserCallRB');
    Route::any('/add-call-record', 'ApiController@addUserCallRecord');

});
