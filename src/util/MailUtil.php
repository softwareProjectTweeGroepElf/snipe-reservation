<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 27/11/2016
 * Time: 15:12
 */

namespace Reservation\util;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use sp2gr11\reservation\fetchers\ReservationFetcher;
use Illuminate\Support\Facades\Mail;
use App\Models\Asset;
use App\Models\User;

class MailUtil
{
    /*public function sendDailyOverview()
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

    }*/

    public function sendDailyOverview(){
        $now = Carbon::now();
        $reservations = ReservationFetcher::getLeasedAssets($now);
        $data=null;

        foreach ($reservations as $idx => $reservation)
        {
            $data[$idx]['first_name'] .= $reservation->user->first_name;
            $data[$idx]['last_name'] .= $reservation->user->last_name;
            $data[$idx]['asset_name'] .= $reservation->asset->name;
        }

        Mail::send('emails.overviewDailyLendableAssets', $data ,function ($m) {
            $m->to(config('mail.from.address'), config('mail.from.name'));
            $m->subject('Overview today \'s lendable assets');
        });
    }

    public static function sendResultDecisionTeacher($decision, $reservation){
        $student_id = $reservation->user_id;
        $student = User::findOrFail($student_id);
        $student_asset_id = $reservation->asset_id;
        $student_asset = Asset::findOrFail($student_asset_id);

        $data = array();
        $data['first_name'] = $student->first_name;
        $data['last_name'] = $student->last_name;
        $data['asset_name'] = $student_asset->name;
        if($decision)
        {
            $data['decision'] = 'accepted';
        }
        else {
            $data['decision'] = 'denied';
        }
        Mail::send('emails.resultDecisionTeacher', $data ,function ($m) use ($student) {
            $m->to($student->email, $student->first_name . ' ' . $student->last_name);
            $m->subject('Decision teacher about your asset');
        });

    }

    public function sendReminderMail(){
        $date = Carbon::tomorrow();
        $reservations = ReservationFetcher::getEndDateLeasedAssets($date->toDateTimeString());

        for ($x = 0; $x < count($reservations); $x++) {
            $user = $reservations[$x]->user;
            $data['first_name'] = $reservations[$x]->user->first_name;
            $data['last_name'] = $reservations[$x]->user->last_name;
            $data['asset_name'] = $reservations[$x]->asset->name;
            Mail::send('emails.reminderMailUser', $data , function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Automatic reminder ending loan period asset');
            });
        }
    }

    public function sendSecondReminderMail(){
        $date = Carbon::yesterday();
        $reservations = ReservationFetcher::getEndDateLeasedAssets($date->toDateTimeString());

        for ($x = 0; $x < count($reservations); $x++) {
            $user = $reservations[$x]->user;
            $data['first_name'] = $reservations[$x]->user->first_name;
            $data['last_name'] = $reservations[$x]->user->last_name;
            $data['asset_name'] = $reservations[$x]->asset->name;

            Mail::send('emails.secondReminderMailUser', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Automatic reminder loan period ended!');
            });
        }
    }

    public function sendEmailWhenAssetIsLendable(){
        $date = Carbon::today();
        $reservations = ReservationFetcher::getLeasedAssets($date->toDateTimeString());

        for ($x = 0; $x < count($reservations); $x++) {
            $user = $reservations[$x]->user;
            $data['first_name'] = $reservations[$x]->user->first_name;
            $data['last_name'] = $reservations[$x]->user->last_name;
            $data['asset_name'] = $reservations[$x]->asset->name;

            Mail::send('emails.assetIsReadyForLoan', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Your asset is ready for loan!');
            });
        }
    }
}