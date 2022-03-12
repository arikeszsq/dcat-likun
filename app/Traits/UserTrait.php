<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait UserTrait
{
    public static function webId()
    {
        return self::user() ? self::user()->web_id : null;
    }

    public static function user()
    {
//        return App::make('user');
        return Auth::guard('admin')->user();
    }

    public static function userId()
    {
        return self::user() ? self::user()->id : null;
    }

    public static function getAdminRole()
    {
        return self::user() ? self::user()->admin_role_id : null;
    }

    public static function isSuperAdmin()
    {
        $admin_role_id = Static::getAdminRole();
        if ($admin_role_id == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function isWebAdmin()
    {
        $admin_role_id = Static::getAdminRole();
        if ($admin_role_id == 2) {
            return true;
        } else {
            return false;
        }
    }

    public static function isAdmin()
    {
        $admin_role_id = Static::getAdminRole();
        if ($admin_role_id == 2 || $admin_role_id == 1) {
            return true;
        } else {
            return false;
        }
    }

}
