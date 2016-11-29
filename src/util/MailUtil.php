<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 27/11/2016
 * Time: 15:12
 */

namespace sp2gr11\reservation\util;

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

    public static function sendResultDecisionTeacher($decision, $reservation){
        $student_id = $reservation->user_id;
        $student = User::find($student_id);
        $student_asset_id = $reservation->asset_id;
        $student_asset = DB::table('assets')->where('id', $student_asset_id);

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
        $reservations = $this->getAllReservations1DayBeforeEndDate();
        $data = array();
        foreach ($reservations as $reservation) {
            $user_id = $reservation->user_id;
            $user = User::find($user_id);
            $user_asset_id = $reservation->asset_id;
            $user_asset = DB::table('assets')->where('id', $user_asset_id);

            $data['first_name'] = $user->first_name;
            $data['last_name'] = $user->last_name;
            $data['asset_name'] = $user_asset->name;

            Mail::send('emails.reminderMailUser', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Automatic reminder ending loan period asset');
            });
        }
    }

    //2e herinnering voor te zeggen dat het te laat is & dat er een boete volgt.

    public function sendSecondReminderMail(){
        $reservations = $this->getAllEndDateReservations();
        $data = array();
        foreach ($reservations as $reservation) {
            $user_id = $reservation->user_id;
            $user = User::find($user_id);
            $user_asset_id = $reservation->asset_id;
            $user_asset = DB::table('assets')->where('id', $user_asset_id);

            $data['first_name'] = $user->first_name;
            $data['last_name'] = $user->last_name;
            $data['asset_name'] = $user_asset->name;

            Mail::send('emails.secondReminderMailUser', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Automatic reminder loan period ended!');
            });
        }
    }

//De student zal een email ontvangen dat zijn gereserveerde item klaar ligt op de uitleendienst.
    public function sendEmailWhenAssetIsLendable(){
        $reservations = $this->getAllAssetsReadyForLoaning();
        $data = array();

        foreach ($reservations as $reservation) {
            $user_id = $reservation->user_id;
            $user = User::find($user_id);
            $user_asset_id = $reservation->asset_id;
            $user_asset = DB::table('assets')->where('id', $user_asset_id);

            $data['first_name'] = $user->first_name;
            $data['last_name'] = $user->last_name;
            $data['asset_name'] = $user_asset->name;

            Mail::send('emails.assetIsReadyForLoan', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Your asset is ready for loan!');
            });
        }
    }
}