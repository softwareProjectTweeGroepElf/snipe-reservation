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
use sp2gr11\reservation\fetchers\ReservationFetcher;
use Illuminate\Support\Facades\Mail;
use App\Models\Asset;
use App\Models\User;

class MailUtil
{

    private $reservation_fetcher;

    public function __construct(ReservationFetcher $reservation_fetcher)
    {
        $this->reservation_fetcher = $reservation_fetcher;
    }

    public function sendDailyOverview(){
        $date = Carbon::today();
        $reservations = $this->reservation_fetcher->getLeasedAssets($date);
        $data=null;
        $data2=null;
        $formatted_date_string = $date->toFormattedDateString();

        for ($x = 0; $x < count($reservations); $x++) {
            $data[$x]['first_name'] = $reservations[$x]->user->first_name;
            $data[$x]['last_name'] = $reservations[$x]->user->last_name;
            $data[$x]['asset_name'] = $reservations[$x]->asset->name;
            $data2['data'] = $data;
            $data2['count'] = count($data);
            $data2['today'] = $formatted_date_string;
        }
        Mail::send('emails.overviewDailyLendableAssets', $data2 ,function ($m) use($formatted_date_string) {
            $m->to(config('mail.from.address'), config('mail.from.name'));
            $m->subject('Overview of ' . $formatted_date_string);
        });
    }

    public function sendReminderMail(){
        $date = Carbon::tomorrow();
        $reservations = $this->reservation_fetcher->getEndDateLeasedAssets($date->toDateTimeString());

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
        $reservations = $this->reservation_fetcher->getEndDateLeasedAssets($date->toDateTimeString());

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
        $reservations = $this->reservation_fetcher->getLeasedAssets($date->toDateTimeString());

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