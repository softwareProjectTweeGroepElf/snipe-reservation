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
            return (RoleUtil::isUserPartOfGroup($user, $reviewerIds));
        else
            return (RoleUtil::isUserPartOfGroup(Auth::user(), $reviewerIds));
    }

    public static function isUserLeasingService($user = null)
    {
        $leasingServiceIds = config('reservation.LEASING_SERVICE_ROLE_ID');

        if($user)
            return (RoleUtil::isUserPartOfGroup($user, $leasingServiceIds));
        else
            return (RoleUtil::isUserPartOfGroup(Auth::user(), $leasingServiceIds));
    }

    public static function isUserPartOfGroup($user, $groups)
    {
        return !empty(array_intersect($user->groups->pluck('id')->all(), $groups));
    }
}