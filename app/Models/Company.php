<?php

namespace App\Models;


use App\Models\CompanyAdminUser;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	protected $fillable = ['name', 'area', 'type', 'nation', 'capital', 'staff', 'status', 'industry', 'contact', 'telephone', 'address', 'license'];

	public function adminUser()
	{
		return $this->belongsTo(CompanyAdminUser::class, 'company_admin_user_id', 'id');
	}
}
