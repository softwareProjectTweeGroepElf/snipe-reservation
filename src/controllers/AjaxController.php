<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 28/11/2016
 * Time: 11:09
 */

namespace sp2gr11\reservation\controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use sp2gr11\reservation\util\CheckInUtil;
use sp2gr11\reservation\util\CheckOutUtil;
use sp2gr11\reservation\util\MailUtil;
use sp2gr11\reservation\util\ReservationUtil;
use sp2gr11\reservation\util\FineUtil;
use sp2gr11\reservation\fetchers\ReservationFetcher;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AjaxController extends Controller
{

    private $reservation_util;
    private $reservation_fetcher;
    private $mail_util;

    public function __construct(ReservationUtil $reservation_util, ReservationFetcher $reservation_fetcher, MailUtil $mail_util)
    {
        $this->reservation_util = $reservation_util;
        $this->reservation_fetcher = $reservation_fetcher;
        $this->mail_util = $mail_util;
    }

    /*
     * Lending Service AJAX
     */
    public function lsaction(
        Request $request,
        CheckOutUtil $check_out_util,
        CheckInUtil $check_in_util,
        FineUtil $fine_util
    ) {
        $asset_id = $request->asset_id;
        $action = $request->asset_action;


        switch ($action) {
            case 'checkout': {
                $check_out_util->checkOutByAssetId($asset_id);
                break;
            }
            case 'checkin': {
                $reservation_archive_id = $check_in_util->checkInByAssetId($asset_id);

                if($this->reservation_util->isAssetOvertime($asset_id))
                    $fine_util->fine($reservation_archive_id);

                break;
            }
        }

        return "Select a legitimate action!";
    }

    public function getAllinfoLS()
    {
        $available_assets = $this->reservation_fetcher->getAvailableAssets();
        $lent_assets = $this->reservation_fetcher->getLeasedAssets();
        $users = User::all();
        $free_users_combo = Array();

        $asset_data = array();

        foreach ($available_assets as $asset) {
            array_push($asset_data, $asset->id, $asset->name);
        }

        foreach ($lent_assets as $asset) {
            array_push($asset_data, $asset->id, $asset->asset->name);
        }

        foreach ($users as $user) {
            array_push($free_users_combo, $user->id, $user->first_name . " " . $user->last_name);
        }

        return ['assets' => $asset_data, 'users' => $free_users_combo];
    }

    /*
     * Student AJAX
     */
    public function getAssetIDandNames()
    {
        $free_assets = $this->reservation_fetcher->getAvailableAssets();
        $data = array();

        foreach ($free_assets as $asset) {
            array_push($data, ['id' => $asset->id, 'name' => $asset->name]);
        }

        return $data;
    }

    public function postReservationRequest(Request $request)
    {
        $this->reservation_util->createReservationRequest(Auth::user()->id, $request->asset_id);
        return true;
    }

    /*
     * Request Reviewer AJAX
     */
    public function postReservation(Request $request)
    {
        $reservation_id = $this->reservation_util->getRequestIdForUserAsset($request->req_asset_id,
            $request->req_user_id);
        $this->reservation_util->acceptReservation($reservation_id);
    }

    public function rejectedReservation(Request $request)
    {
        $this->reservation_util->rejectReservation($this->reservation_util->getRequestIdForUserAsset($request->req_asset_id,
            $request->req_user_id));
    }

    public function getLeasedAssetsExceptOvertime()
    {
        return $this->reservation_fetcher->getLeasedAssetsExceptOvertime();
    }

    /*
     * Calendar
     */

    public function getAssetReservationsForMonth(Request $request)
    {
        return $this->reservation_fetcher->getReservationsForMonth($request->asset_id, $request->month);
    }

    /*
     * Mails
     */


    public function getMailReminder(){
        $this->mail_util->sendReminderMail();
    }
    public function getMailSecondReminder(){
        $this->mail_util->sendSecondReminderMail();
    }
    public function getMailDailyOverview(){
        $this->mail_util->sendDailyOverview();
    }
    public function getMailLendableAsset(){
        $this->mail_util->sendEmailWhenAssetIsLendable();
    }

    public function sendResultDecisionTeacher(Request $request){
        $req_user = User::find($request->req_user_id);
        $req_asset = Asset::find($request->req_asset_id);
        $data['first_name'] = $req_user->first_name;
        $data['last_name'] = $req_user->last_name;
        $data['asset_name'] =$req_asset->name;
        $data['decision'] = $request->req_decision;
        Mail::send('emails.resultDecisionTeacher', $data ,function ($m) use ($req_user) {
            $m->to($req_user->email, $req_user->first_name . ' ' . $req_user->last_name);
            $m->subject('Decision teacher about your assetrequest');
        });
    }

    public function searchAvailableAssets($text, $filter)
    {
        return $this->reservation_fetcher->getAvailableAssetsBy($text, $filter);
    }
}