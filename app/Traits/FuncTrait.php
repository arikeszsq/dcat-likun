<?php
namespace App\Traits;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;


/**
 * Created by PhpStorm.
 * User: lxg
 * Date: 2020-1-9
 * Time: 下午3:08
 */
trait FuncTrait
{
    /**
     * 为php在查询时处理一些有特殊意义的字符（当前处理%,_）
     * @param $str
     * @return string
     */
    public static function addslashes_str($str)
    {
        //转义空白字符
        $str = addslashes($str);

        //处理 %
        $str = str_replace('%', '\%', $str);

        //处理 _
        $str = str_replace('_', '\_', $str);

        return $str;
    }



}
