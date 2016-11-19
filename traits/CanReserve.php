<?php

/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 18/11/2016
 * Time: 0:46
 */
trait CanReserve
{
    public function assigned_assets()
    {
        return $this->belongsToMany('App\Models\Asset', 'reservation_assets');
    }
}