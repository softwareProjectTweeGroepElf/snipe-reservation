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
        $reviewerIds = config('reservation.REVIEWER_ROLE_ID');

        if($user)
            return ($user->role->id == $reviewerId);
        else
            return (Auth::user()->role->id == $reviewerId);
    }

    public static function isUserLeasingService($user = null)
    {
        $leasingServiceIds = config('reservation.LEASING_SERVICE_ROLE_ID');

        if($user)
            return (in_array($user->role->id, $leasingServiceIds));
        else
            return (in_array(Auth::user()->role->id, $leasingServiceIds));
    }
}