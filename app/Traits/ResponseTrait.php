<?php
namespace App\Traits;

use App\Constants\ResponseCodeConstant;
use Illuminate\Http\JsonResponse;
use stdClass;

/**
 * Created by PhpStorm.
 * User: codeanti
 * Date: 2020-1-4
 * Time: 下午3:08
 */
trait ResponseTrait
{
    /**
     * 找不到资源 统一返回格式
     * @param string $message
     * @return JsonResponse
     * @author CodeAnti
     */
    public static function resourceNotFound($message = "Not Found Resource")
    {
        return self::encodeResult(ResponseCodeConstant::CONSTANT_RESPONSE_CODE_NOT_FUND_RESOURCE, $message);
    }

    /**
     * 参数不合法 统一返回格式
     * @param null $message
     * @return JsonResponse
     * @author CodeAnti
     */
    public static function parametersIllegal($message = null)
    {
        return self::encodeResult(ResponseCodeConstant::CONSTANT_RESPONSE_CODE_PARAM_ILLEGAL, $message);
    }


    /**
     * 正确的返回统一格式
     * @param $data
     * @return JsonResponse
     * @author CodeAnti
     */
    public static function success($data = null)
    {
        return self::encodeResult(ResponseCodeConstant::CONSTANT_RESPONSE_CODE_SUCCESS, 'success', $data);
    }

    /**
     * 失败的返回统一格式
     * @param $message
     * @return JsonResponse
     * @author CodeAnti
     */
    public static function fail($message = null)
    {
        return self::encodeResult(ResponseCodeConstant::CONSTANT_RESPONSE_CODE_FAILED, $message);
    }

    /**
     * 错误的返回统一格式
     * @param $code
     * @param null $message
     * @param $data
     * @return JsonResponse
     * @author CodeAnti
     */
    public static function error($code, $message = null, $data = null)
    {
        return self::encodeResult($code, $message, $data);
    }

    /**
     * 统一返回格式
     * @param  $msgCode
     * @param  $message
     * @param  $data
     * @return JsonResponse
     * @author CodeAnti
     */
    public static function encodeResult($msgCode, $message = null, $data = null)
    {
        if ($data == null) {
            $data = new stdClass();
        }

        $result = [
            'msg_code'    => $msgCode,
            'message'     => $message,
            'response'    => $data,
            'server_time' => time()
        ];
        return response()->json($result);
    }
}
