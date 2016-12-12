<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 29/11/2016
 * Time: 19:10
 */

namespace sp2gr11\reservation\controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class CronjobController extends Controller
{

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call('app\controllers\ReservationController@sendDailyOverviewToHeadOfTheLendingService')->dailyAt('06:00');
        $schedule->call('app\controllers\ReservationController@sendReminderMailToUsers')->dailyAt('06:00');
        $schedule->call('app\controllers\ReservationController@sendSecondReminderMailToUsers')->dailyAt('06:00');
        $schedule->call('app\controllers\ReservationController@sendEmailToStudentWhenAssetIsReadyForLoan')->dailyAt('06:00');
    }
}