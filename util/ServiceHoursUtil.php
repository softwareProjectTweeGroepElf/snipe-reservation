<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 25/11/2016
 * Time: 17:21
 */

namespace Reservation\Util;
use Carbon\Carbon;

class ServiceHoursUtil
{
    /**
     * @return bool Checks if the lending service is currently open, true if yes, false if not
     */
    public static function isCurrentlyOpen()
    {
        $hours_today = self::getServiceHoursToday();
        return Carbon::now()->between($hours_today[0], $hours_today[1]);
    }

    /**
     * @return array An array containing 2 Carbon instances of the service hours today, first index is from, second index is until
     */
    public static function getServiceHoursToday()
    {
        $hours_of_service = config('reservation.HOURS_OF_SERVICE');
        $now = Carbon::now();
        $day = $now->dayOfWeek == 0 ? 6 : $now->dayOfWeek - 1;

        $hours = explode('-', $hours_of_service[$day]);

        return $hours;
    }
}