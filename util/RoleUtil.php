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

    public static function isUserReviewer($user = null)
    {
        $reviewerId = config('reservation.REVIEWER_ROLE_ID');

        if($user)
            return ($user->role->id == $reviewerId);
        else
            return (Auth::user()->role->id == $reviewerId);
    }

    public static function isUserLeasingService($user = null)
    {
        $leasingServiceId = config('reservation.LEASING_SERVICE_ROLE_ID');

        if($user)
            return ($user->role->id == $leasingServiceId);
        else
            return (Auth::user()->role->id == $leasingServiceId);
    }


}