<?php

namespace App\Http\Controllers;


use App\Models\TuokecmaOption;
use App\Models\Tuokema;
use App\Models\UserTK;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use zgldh\QiniuStorage\QiniuStorage;

class IndexController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $inputs = $request->all();
        $type = isset($inputs['type']) && $inputs['type'] ? $inputs['type'] : 1;
        if ($type == 1) {
            //拓客码
            $id = isset($inputs['id']) && $inputs['id'] ? $inputs['id'] : 0;
            $data = [
                'image' => '/static/web/images/banner.png',
                'web_id' => 1,
                'master_id' => 1
            ];
            if ($id) {
                $obj = Tuokema::query()->find($id);
                $master_id = $obj->user_id;
                $web_id = $obj->web_id;
                $option_id = $obj->option_id;
                $option = TuokecmaOption::query()->find($option_id);
                $data = [
                    'image' => $option->banner ?? '/static/web/images/banner.png',
                    'web_id' => $web_id,
                    'master_id' => $master_id
                ];
            }
            return view('index', $data);
        }
    }

    public function add(Request $request)
    {
        $inputs = $request->all();
        $validator = \Validator::make($inputs, [
            'company_name' => 'required',
            'user_name' => 'required',
            'mobile' => 'required'
        ], [
            'company_name' => '企业名称必填',
            'user_name' => '联系人必填',
            'mobile' => '手机号必填'
        ]);
        if ($validator->fails()) {
            return self::parametersIllegal($validator->messages()->first());
        }
        try {
            $data = [
                'web_id' => $inputs['web_id'],
                'master_id' => $inputs['master_id'],
                'company_name' => $inputs['company_name'],
                'user_name' => $inputs['user_name'],
                'mobile' => $inputs['mobile'],
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ];
            $ret = UserTK::query()->insert($data);
            return self::success($ret);
        } catch (\Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }

    public function resultPage()
    {
        return view('result', ['msg' => '成功']);
    }

//    public function update(Request $request)
//    {
//        $inputs = $request->all();
//        $data = [
//            'company_tax_no' => $this->getKeyValue('company_tax_no', $inputs),
//            'money_need' => $this->getKeyValue('money_need', $inputs),
//            'legal_name' => $this->getKeyValue('legal_name', $inputs),
//            'legal_id_card' => $this->getKeyValue('legal_id_card', $inputs),
//            'legal_mobile' => $this->getKeyValue('legal_mobile', $inputs),
//            'legal_bank_no' => $this->getKeyValue('legal_bank_no', $inputs),
//            'bank' => $this->getKeyValue('bank', $inputs),
//            'legal_company' => $this->getKeyValue('legal_company', $inputs),
//            'legal_house' => $this->getKeyValue('legal_house', $inputs),
//            'edu' => $this->getKeyValue('edu', $inputs),
//            'marry' => $this->getKeyValue('marry', $inputs),
//            'marry_name' => $this->getKeyValue('marry_name', $inputs),
//            'marry_mobile' => $this->getKeyValue('marry_mobile', $inputs),
//            'marry_id_card' => $this->getKeyValue('marry_id_card', $inputs),
//            'marry_work_detail' => $this->getKeyValue('marry_work_detail', $inputs),
//            'pre_mobile' => $this->getKeyValue('pre_mobile', $inputs),
//            'relation_o' => $this->getKeyValue('relation_o', $inputs),
//            'relation_mob_o' => $this->getKeyValue('relation_mob_o', $inputs),
//            'relation_t' => $this->getKeyValue('relation_t', $inputs),
//            'relation_mob_t' => $this->getKeyValue('relation_mob_t', $inputs),
//            'cert_pic' => json_encode($this->getKeyValue('cert_pic', $inputs)),
//            'id_card_pic' => json_encode($this->getKeyValue('id_card_pic', $inputs))
//        ];
//        try {
//            $ret = User::query()->where('id', $inputs['id'])->update($data);
//            return self::success($ret);
//        } catch (\Exception $e) {
//            return self::error($e->getCode(), $e->getMessage());
//        }
//
//    }

    function getKeyValue($key, $inputs)
    {
        return isset($inputs[$key]) && $inputs[$key] ? $inputs[$key] : '';
    }


    public function upload(Request $request)
    {
        $file = $request->file('file');
        $url_path = 'images/' . date('Y-m-d') . '/';
        if (!file_exists($url_path)) {
            mkdir($url_path, 0700, true);
        }
        $rule = ['jpg', 'png', 'gif', 'jpeg', 'bmp'];
        if ($file->isValid()) {
            $clientName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            if (!in_array($extension, $rule)) {
                return '图片格式支持gif,jpg,jpeg,bmp,png';
            }
            $newName = md5(date("Y-m-d H:i:s") . $clientName) . "." . $extension;
            $file->move($url_path, $newName);
            return $url_path . $newName;
        }
    }


    public function uploadFile(Request $request)
    {
        $files = $request->file();
        var_dump($files);
        var_dump($_FILES);

        print_r($files);
        print_r($_FILES);


        Log::info($files);
        Log::info($_FILES);

        Log::info(666666666666);
        $content = file_get_contents('php://input');

        Log::info($content);
        Log::info(date('Y-m-d H:i:s', time()));


//
//        var_dump($_FILES);
//        var_dump($_POST);
//
//        $file = $request->file('file');
//        //获取文件的扩展名
//        $kuoname = $file->getClientOriginalExtension();
//        //获取文件的绝对路径，但是获取到的在本地不能打开
//        $path = $file->getRealPath();
//        //要保存的文件名 时间+扩展名
//        $filename = date('Y-m-d-H-i-s') . '_' . uniqid() . '.' . $kuoname;
//        $disk = QiniuStorage::disk('qiniu');
//        $bool = $disk->put($filename, file_get_contents($path));
//        if ($bool) {
//            $path = $disk->downloadUrl($filename);
//            return '上传成功，url:' . $path;
//        }
//        return '上传失败';
    }


}
