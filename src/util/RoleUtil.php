<?php

namespace sp2gr11\reservation\util;
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 18/11/2016
 * Time: 1:32
 */

use Illuminate\Support\Facades\Auth;
class RoleUtil
{
    /**
     * @param The user to check for, if not given will check the authenticated user instead
     * @return True if the user is able to review reservation requests, false if not
     */
    public static function isUserReviewer($user = null)
    {
        $reviewerIds = config('reservation.REVIEWER_ROLE_ID');

        if($user)
            return (RoleUtil::isUserPartOfGroup($user, $reviewerIds));
        else
            return (RoleUtil::isUserPartOfGroup(Auth::user(), $reviewerIds));
    }

    /**
     * @param The user to check for, if not given will check the authenticated user instead
     * @return True if the user is part of the leasing service, false if not
     */
    public static function isUserLeasingService($user = null)
    {
        $leasingServiceIds = config('reservation.LEASING_SERVICE_ROLE_ID');

        if($user)
            return (RoleUtil::isUserPartOfGroup($user, $leasingServiceIds));
        else
            return (RoleUtil::isUserPartOfGroup(Auth::user(), $leasingServiceIds));
    }

    /**
     * @param The user to check the groups of
     * @param array An array of group IDs to check if the User is part of any of them
     * @return True if the user is part of any of the groups, false if not
     */
    public static function isUserPartOfGroup($user, array $required_group_ids)
    {
        $user_group_ids = array();
        foreach($user->groups as $group)
            $group_ids[] = $group->id;

        return !empty(array_intersect($user_group_ids, $required_group_ids));
    }


}