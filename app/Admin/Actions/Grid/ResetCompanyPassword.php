<?php

namespace App\Admin\Actions\Grid;

use App\Models\CompanyAdminUser;
use Illuminate\Http\Request;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Actions\Response;
use Illuminate\Support\Facades\Hash;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class ResetCompanyPassword extends RowAction
{
    /**
     * @return string
     */
    protected $title = '<i title="重置密码" class="feather icon-lock"></i>';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $model = CompanyAdminUser::query()->where('id', $request->input('company_admin_user_id'))->first();
        $model->password = Hash::make('a123456');
        $model->save();
        return $this->response()
            ->success('密码已重置为初始密码：a123456')
            ->redirect('companies');
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        return ['确定要重置密码吗？', $this->row->name];
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [
            'company_admin_user_id' => $this->row->company_admin_user_id
        ];
    }
}
