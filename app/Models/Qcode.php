<?php

namespace App\Models;


use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Qcode extends Model
{
    use UserTrait;

    static public function qrcodeWithBg($url, $img = null, $x = null, $y = null)
    {
        if (!$img) {
            $img = 'static/img/code_bg.png';
        }
        if (!$x) {
            $x = 80;
        }
        if (!$y) {
            $y = 350;
        }
        $file = DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "qrcode" . DIRECTORY_SEPARATOR;
        if (!file_exists(public_path($file))) {
            mkdir(public_path($file), 0777, true);
        }
        $user_id = self::userId();
        $path_all = $file . $user_id . '-' . time() . ".png";
        QrCode::format('png')->errorCorrection('L')
            ->size(200)->generate($url, public_path($path_all));
        $qrcode['path'] = $path_all;
        $bg = imagecreatefromstring(file_get_contents($img));// 提前准备好的海报图  必须是PNG格式
        $qrcodes = imagecreatefrompng(public_path($path_all)); //二维码
        imagecopyresampled($bg, $qrcodes, $x, $y, 0, 0, imagesx($qrcodes), imagesx($qrcodes), imagesx($qrcodes), imagesx($qrcodes));
        imagepng($bg, public_path($path_all)); //合并图片
        return $path_all;
    }

    static public function qrcode($url)
    {
        $file = DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "qrcode" . DIRECTORY_SEPARATOR;
        if (!file_exists(public_path($file))) {
            mkdir(public_path($file), 0777, true);
        }
        $user_id = self::userId();
        $path = $file . $user_id . '-2-' . time() . ".png";
        QrCode::format('png')->errorCorrection('L')
            ->size(200)->generate($url, public_path($path));
        $qrcode['path'] = $path;
        return $path;
    }

}
