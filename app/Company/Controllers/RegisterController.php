<?php

namespace App\Company\Controllers;

use Carbon\Carbon;
use Dcat\Admin\Layout\Row;
use Illuminate\Support\Str;
use Dcat\Admin\Widgets\Form;
use Illuminate\Http\Request;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use App\Models\CompanyAdminUser;
use Illuminate\Support\Facades\DB;
use App\Repositories\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Dcat\Admin\Traits\HasUploadedFile;

class RegisterController extends Controller
{

    use HasUploadedFile;

    public function index(Content $content)
    {
        $form = new Form(new Company());

        $form->text('name', '公司名');
        $form->text('username', '登录账号名')->required()->rules('integer')->help('请填写登录账号名，限6-20位字母、数字或下划线');
        $form->password('password', '登录密码')->required()->help('请填写6-30位的密码');
        $form->password('password_confirmation', '确认密码')->required()->help('请再次输入您的密码');
        $form->select('area', '所属区域')->options(Company::AREA_ARRAY)->required()->help('请选择所属区域');
        $form->select('nation', '投资国别')->options(Company::NATION_ARRAY)->required()->help('请选择投资国别');
        $form->select('industry', '行业大类')->options(Company::INDUSTRY_ARRAY)->required()->help('请选择行业大类');
        $form->select('type', '企业类型')->options(Company::TYPE_ARRAY)->required()->help('请选择企业类型');
        $form->select('capital', '资金规模')->options(Company::CAPITAL_ARRAY)->required()->help('请选择企业资金规模');
        $form->select('staff', '员工人数')->options(Company::STAFF_ARRAY)->required()->help('请选择企业员工人数');
        $form->file('license', '营业执照')->url('register/upload')->autoUpload()->required()->help('请上传营业执照，附件格式：2M以内的jpeg,png,jpg,gif,pdf文件');
        $form->text('contact', '联系人')->required()->help('请填写联系人');
        $form->text('telephone', '联系方式')->required()->help('请填写联系方式');
        $form->text('address', '企业实际经营地址')->required()->help('请填写企业实际经营地址');

        return $content->full()
            ->title('公司注册')
            ->body(function (Row $row) use ($form) {
                // $row->column(12, view('company.layouts.site-header'));
                $row->column(12, view('company.register.title'));
                $row->column(12, function (Column $column) use ($form) {
                    $column->row(function (Row $row) use ($form) {
                        $row->column(3, '');
                        $row->column(6, view('company.register.form', compact('form')));
                        $row->column(3, '');
                    });
                });
                // $row->column(12, view('company.layouts.site-footer'));
            });
    }

    public function do(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:companies,name',
            'username' => 'required|regex:/[0-9a-zA-Z_]{6,20}/|unique:company_admin_users,username',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'area' => 'required',
            'type' => 'required',
            'nation' => 'required',
            'industry' => 'required',
            'capital' => 'required',
            'staff' => 'required',
            'contact' => 'required|max:191',
            'telephone' => 'required|max:191',
            'license' => 'required|max:191',
            'address' => 'required|max:191',
        ], [
            '*.required' => ':attribute必填',
            '*.unique' => ':attribute已被占用',
            '*.regex' => ':attribute不符合规则',
            '*.confirmed' => '两次输入的密码不一样',
            '*.mimes' => '允许上传的文件格式包括：:mimes',
            'license.max' => '营业执照附件大小不得超过 :max KB'
        ], [
            'name' => '企业名称',
            'username' => '登录账号名',
            'password' => '登录密码',
            'password_confirmation' => '确认密码',
            'area' => '所属区域',
            'type' => '企业类型',
            'nation' => '投资国别',
            'industry' => '行业大类',
            'capital' => '投资规模',
            'staff' => '员工规模',
            'contact' => '联系人',
            'telephone' => '联系人手机号',
            'license' => '营业执照',
            'address' => '企业实际经营地址'
        ]);

        DB::beginTransaction();
        try {
            $adminUser = new CompanyAdminUser();
            $adminUser->fill($request->post());
            $adminUser->password = Hash::make($request->post('password'));
            if (!$adminUser->save()) {
                throw new \Exception('用户账号创建失败');
            }
            $company = new \App\Models\Company();
            $company->company_admin_user_id = $adminUser->id;
            $company->fill($request->post());
            $company->status = Company::STATUS_WAIT;
            if (!$company->save()) {
                throw new \Exception('企业信息保存失败');
            }
            DB::table(config('company.database.role_users_table'))->insert(
                ['role_id' => 2, 'user_id' => $adminUser->id,'created_at'=>Carbon::now(),'updated_at'=>Carbon::now()]
            );
            DB::commit();
            return (new Form())->response()->success('提交成功，请等待审核')->refresh();
        } catch (\Exception $exception) {
            DB::rollBack();
            return (new Form())->response()->error('注册失败');
        }
    }

    public function upload()
    {
        $disk = $this->disk('company');

        // 判断是否是删除文件请求
        if ($this->isDeleteRequest()) {
            // 删除文件并响应
            return $this->deleteFileAndResponse($disk);
        }

        // 获取上传的文件
        $file = $this->file();

        $dir = 'license';
        $newName = Str::random(18) . '.' . $file->getClientOriginalExtension();

        $result = $disk->putFileAs($dir, $file, $newName);

        $path = "{$dir}/$newName";

        return $result
            ? $this->responseUploaded($path, $disk->url($path))
            : $this->responseErrorMessage('文件上传失败');
    }

    public function success(Content $content)
    {
        return $content->full()
            ->title('注册成功')
            ->body(function (Row $row) {
                $row->column(12, view('company.layouts.site-header'));
                $row->column(12, view('company.register.title'));
                $row->column(12, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(3, '');
                        $row->column(6, view('company.register.success'));
                        $row->column(3, '');
                    });
                });
                $row->column(12, view('company.layouts.site-footer'));
            });
    }
}
