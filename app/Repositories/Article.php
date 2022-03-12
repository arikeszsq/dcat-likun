<?php

namespace App\Repositories;

use App\Models\Article as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Article extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    const STATUS_OK = 1;
    const STATUS_CLOSE = 0;

    const STATUS_ARRAY = [
        self::STATUS_OK => '正常',
        self::STATUS_CLOSE => '关闭',
    ];

    const TYPE_NEWS = 1;
    const TYPE_NOTICE = 2;
    //todo 其他类型

    const TYPE_ARRAY = [
        self::TYPE_NEWS => '新闻',
        self::TYPE_NOTICE => '公告',
    ];
}
