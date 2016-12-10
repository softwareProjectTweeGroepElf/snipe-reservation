<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 25/11/2016
 * Time: 17:21
 */

namespace Reservation\util;
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
        $day = $now->dayOfWeek == 0 ? 6 : $now->dayOfWeek - 1; // Because dayOfWeek returns 0 on sunday,
                                                                // and in our config array monday is on 0 we need to make sure we get the correct results
        $hours = explode('-', $hours_of_service[$day]);
        $hours[0] = Carbon::createFromFormat('H:m', $hours[0]);
        $hours[1] = Carbon::createFromFormat('H:m', $hours[1]);

        return $hours;
    }
}