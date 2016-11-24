<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 24/11/2016
 * Time: 18:21
 */

namespace App\Console;

use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*$schedule->call(function () {
            DB::table('recent_users')->delete();
        })->daily();
        $schedule->call('\App\Http\Controllers\CronController@getPublish')->cron('* * * * *');*/

        $schedule->call('app\controllers\ReservationController@sendDailyOverviewToHeadOfTheLendingService')->daily();
    }
}