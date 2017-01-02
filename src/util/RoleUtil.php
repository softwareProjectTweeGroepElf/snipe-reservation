<?php

namespace sp2gr11\reservation\util;
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 18/11/2016
 * Time: 1:32
 */

use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Auth;
class RoleUtil
{

    private $connection;
    private $config_util;

    public function __construct(Connection $connection, ConfigUtil $config_util)
    {
        $this->connection = $connection;
        $this->config_util = $config_util;
        $this->config_util->initConfig();
    }
    /**
     * @param The user to check for, if not given will check the authenticated user instead
     * @return True if the user is able to review reservation requests, false if not
     */
    public function isUserReviewer($user = null)
    {
        $reviewer_groups = $this->config_util->option('REVIEWER_ROLES');

        if($user)
            return ($this->isUserPartOfGroup($user, $reviewer_groups));
        else
            return ($this->isUserPartOfGroup(Auth::user(), $reviewer_groups));
    }

    /**
     * @param The user to check for, if not given will check the authenticated user instead
     * @return True if the user is part of the leasing service, false if not
     */
    public function isUserLeasingService($user = null)
    {
        $leasing_service_groups = $this->config_util->option('LEASING_SERVICE_ROLES');

        if($user)
            return ($this->isUserPartOfGroup($user, $leasing_service_groups));
        else
            return ($this->isUserPartOfGroup(Auth::user(), $leasing_service_groups));
    }

    /**
     * @param The user to check the groups of
     * @param array An array of group IDs to check if the User is part of any of them
     * @return True if the user is part of any of the groups, false if not
     */
    public function isUserPartOfGroup($user, array $required_groups)
    {
        $user_groups = array();
        foreach($user->groups as $group)
            $user_groups[] = $group->name;

        return !empty(array_intersect($user_groups, $required_groups));
    }


}