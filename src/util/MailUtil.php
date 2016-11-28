<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 27/11/2016
 * Time: 15:12
 */

namespace Reservation\Util;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Reservation\Fetchers\ReservationFetcher;
use Illuminate\Support\Facades\Mail;

class MailUtil
{
    public function sendDailyOverview()
    {
        $now = Carbon::now();
        $new_reservations = ReservationFetcher::getLeasedAssets($now->toDateString());

        $day_date_time = $now->toDayDateTimeString();

        $mail_content = 'Assets Lent Today\n\n';
        foreach($new_reservations as $reservation)
        {
            $lent_time = Carbon::createFromTimestamp($reservation->from);
            $mail_content = $mail_content . 'Lent ' . $reservation->asset->name .
                ' to ' . $reservation->user->first_name . ' ' . $reservation->user->last_name .
                ' at ' . $lent_time->toTimeString();
        }

        Mail::send('emails.overview', ['content' => $mail_content, 'date_time' => $day_date_time], function($message) {
            $message->subject('Overview of ' . $date_time);
            $message->from('noreply@snipeit.com', 'SnipeIT');
            $message->to(config('reservation.MANAGER_EMAIL'));
        });

    }
}