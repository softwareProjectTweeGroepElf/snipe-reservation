<?php

namespace Reservation\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 17/11/2016
 * Time: 22:11
 */
class Role extends Model
{
    protected $table = 'reservation_roles';

    protected $hidden = [ 'created_at', 'updated_at' ];
}