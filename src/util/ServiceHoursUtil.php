<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 25/11/2016
 * Time: 17:21
 */

namespace sp2gr11\reservation\util;
use Carbon\Carbon;

class ServiceHoursUtil
{
    private $hours_of_service;
    private $config_util;

    public function __construct(ConfigUtil $config_util)
    {
        $this->config_util = $config_util;
        $this->config_util->initConfig();
        $this->hours_of_service = $this->config_util->option('HOURS_OF_SERVICE');
    }
    /**
     * @return bool Checks if the lending service is currently open, true if yes, false if not
     */
    public function isCurrentlyOpen()
    {
        $hours_today = $this->getServiceHoursToday();
        $current_hour = Carbon::now()->hour + (Carbon::now()->minute / 100);
        $open_hour = $hours_today[0]->hours + ($hours_today[0]->minute / 100);
        $closed_hour = $hours_today[1]->hours + ($hours_today[1]->minute / 100);

        return ($current_hour >= $open_hour && $current_hour < $closed_hour);
    }

    /**
     * @return array An array containing 2 Carbon instances of the service hours today, first index is from, second index is until
     */
    public function getServiceHoursToday()
    {
        $now = Carbon::now();
        $day = $now->dayOfWeek == 0 ? 6 : $now->dayOfWeek - 1; // Because dayOfWeek returns 0 on sunday,
                                                                // and in our config array monday is on 0 we need to make sure we get the correct results
        $hours = explode('-', $this->hours_of_service[$day]);
        $hours[0] = Carbon::createFromFormat('H:m', $hours[0]);
        $hours[1] = Carbon::createFromFormat('H:m', $hours[1]);

        return $hours;
    }
}