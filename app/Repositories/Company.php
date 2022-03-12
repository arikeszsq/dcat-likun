<?php

namespace App\Repositories;

use App\Models\Company as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Company extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    	
	const STATUS_OK = 1;   //正常
    const STATUS_WAIT = 2;  //待审核
    const STATUS_REFUSE = 3;   //拒绝
    const STATUS_CLOSE = 4;   //禁用

    const STATUS = [
        self::STATUS_OK => '正常',
        self::STATUS_WAIT => '待审核',
        self::STATUS_REFUSE => '审核不通过',
        self::STATUS_CLOSE => '禁用'
    ];

    const AREA_ARRAY = [
        1 => '度假区',
        2 => '高贸区',
        3 => '商务区',
        4 => '科创区',
    ];

    const TYPE_ARRAY = [
        1 => '民营企业',
        2 => '国有企业',
        3 => '外资企业',
        4 => '中外合资企业'
    ];

    const NATION_ARRAY = [
        1 => '欧美',
        2 => '日韩',
        3 => '国内企业',
        4 => '亚洲企业（除国内和日韩资）'
    ];

    const CAPITAL_ARRAY = [
        1 => '100万元以下',
        2 => '100-500万元',
        3 => '500-1000万元',
        4 => '1000万元及以上'
    ];

    const STAFF_ARRAY = [
        1 => '100以下',
        2 => '100人至500人',
        3 => '500人至1000人',
        4 => '1000人以上',
    ];

    const INDUSTRY_ARRAY = [
        10 => '农、林、牧、渔业',
        20 => '采矿业',
        30 => '制造业',
        40 => '电力、热力、燃气及水生产和供应业',
        50 => '建筑业',
        60 => '批发和零售业',
        70 => '交通运输、仓储和邮政业',
        80 => '住宿和餐饮业',
        90 => '信息传输、软件和信息技术服务业',
        100 => '金融业',
        110 => '房地产业',
        120 => '租赁和商务服务业',
        130 => '科学研究和技术服务业',
        140 => '水利、环境和公共设施管理业',
        150 => '居民服务、修理和其他服务业',
        160 => '教育',
        170 => '卫生和社会工作',
        180 => '文化、体育和娱乐业',
        190 => '公共管理、社会保障和社会组织',
        200 => '国际组织'
    ];
}
