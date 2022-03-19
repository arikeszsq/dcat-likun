<?php

namespace App\Admin\Forms;

use App\Models\JfUserExcel;
use App\Traits\UserTrait;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportExcel extends Form
{
    use UserTrait;

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        set_time_limit(600);
        ini_set("max_execution_time", "600");
        $file = $input['file'];
        $file_path = public_path($file);
        $spreadsheet = IOFactory::load($file_path);
        $sheet = $spreadsheet->getActiveSheet();
        // 取得总行数
        $highestRow = $sheet->getHighestRow();
        $data = [];
        $batch_no = date('YmdHis', time());
        $create_time = date('Y-m-d H:i:s', time());
        $web_id = static::webId();
        $user_id = static::userId();
        $i = 0;
        for ($j = 2; $j <= $highestRow; $j++) {
            $data[$i]['company_name'] = $sheet->getCell("A" . $j)->getValue();
            $data[$i]['user_name'] = $sheet->getCell("B" . $j)->getValue();
            $data[$i]['mobile'] = $sheet->getCell("C" . $j)->getValue();
            $data[$i]['source'] = $sheet->getCell("D" . $j)->getValue();
            $data[$i]['web_id'] = $web_id;
            $data[$i]['user_id'] = $user_id;
            $data[$i]['master_id'] = $user_id;
            $data[$i]['created_at'] = $create_time;
            $data[$i]['updated_at'] = $create_time;
            $data[$i]['batch_no'] = $batch_no;
            $i++;
        }
        try {
            if ($highestRow > 1000) {
                $array = array_chunk($data, 1000);
                foreach ($array as $v) {
                    DB::table('jf_user_excel')->insert($v);
                }
            } else {
                DB::table('jf_user_excel')->insert($data);
            }
            return $this->response()->success('成功导入' . count($data) . '条数据')->refresh();
        } catch (\Exception $exception) {
            return $this
                ->response()
                ->error('导入失败：' . $exception->getMessage())
                ->refresh();
        }
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->file('file', 'Excel文件')
            ->options(['showPreview' => false,
                'allowedFileExtensions' => ['xlsx', 'xls'],
                'showUpload' => false
            ])->rules('required', ['required' => '文件不能为空']);
    }
}
