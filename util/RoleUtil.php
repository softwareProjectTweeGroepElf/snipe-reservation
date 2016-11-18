<?php

namespace Reservation\Util;
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 18/11/2016
 * Time: 1:32
 */

class RoleUtil
{
    public static function checkUserRole($role_id, $user = null) // will automatically try to get user from Auth if no $user is provided
    {
        if($user)
            return ($user->role->id == $role_id);
        else
            return (Auth::user()->role->id == $role_id);
    }
}