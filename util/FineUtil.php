<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 25/11/2016
 * Time: 9:16
 */

namespace Reservation\Util;

use Carbon;


class FineUtil
{
    public static function calculateFine($reservation_id)
    {
        $until_date = Carbon::createFromFormat('Y/m/d', DB::table('reservation_assets')->select('until')->where('id', $reservation_id)->first());
        $diff = Carbon::now()->diffInHours($until_date);

        return round($diff * 0.20, 2);
    }
}