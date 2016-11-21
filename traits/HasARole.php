<?php

/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 17/11/2016
 * Time: 22:26
 */

trait HasARole
{
    public function role()
    {
        return $this->hasOne('Reservation\Models\Role');
    }
}