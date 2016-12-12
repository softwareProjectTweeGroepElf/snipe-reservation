<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 28/11/2016
 * Time: 11:09
 */

namespace Reservation\controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Reservation\util\CheckOutUtil;
use Reservation\util\CheckInUtil;
use Reservation\util\ReservationUtil;
use Reservation\util\FineUtil;
use Reservation\fetchers\ReservationFetcher;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{

    private $reservation_util;
    private $reservation_fetcher;

    public function __construct(ReservationUtil $reservation_util, ReservationFetcher $reservation_fetcher)
    {
        $this->reservation_util = $reservation_util;
        $this->reservation_fetcher = $reservation_fetcher;
    }
    /*
     * Lending Service AJAX
     */
    public function lsaction(Request $request, CheckOutUtil $check_out_util, CheckInUtil $check_in_util, FineUtil $fine_util){
        $asset_id = $request->asset_id;
        $action =  $request->asset_action;


        switch($action)
        {
            case 'checkout':
            {
                $check_out_util->checkOutByAssetId($asset_id);
                break;
            }
            case 'checkin':
            {
                $check_in_util->checkInByAssetId($asset_id);
                break;
            }
            case 'overtime':
            {
                $check_in_util->checkInByAssetId($asset_id);
                $fine_util->calculateFine($this->reservation_util->getReservationIdForAsset($asset_id));
                break;
            }
        }

        return "Select a legitimate action!";
    }

    public function getAllinfoLS(){
        $available_assets = $this->reservation_fetcher->getAvailableAssets();
        $lent_assets = $this->reservation_fetcher->getLeasedAssets();
        $users = User::all();
        $free_users_combo = Array();

        $asset_data = array();

        foreach($available_assets as $asset)
            array_push($asset_data, $asset->id, $asset->name);

        foreach($lent_assets as $asset)
            array_push($asset_data, $asset->id, $asset->name);

        foreach ($users as $user)
            array_push($free_users_combo, $user->id, $user->first_name." ". $user->last_name);

        return ['assets' => $asset_data, 'users' => $free_users_combo];
    }

    /*
     * Student AJAX
     */
    public function getAssetIDandNames()
    {
        $free_assets = $this->reservation_fetcher->getAvailableAssets();
        $data = array();

        foreach($free_assets as $asset)
            array_push($data, ['id' => $asset->id, 'name' => $asset->name]);

        return $data;
    }

    public function postReservationRequest(Request $request){
        $this->reservation_util->createReservationRequest(Auth::user()->id, $request->asset_id);
        return true;
    }

    /*
     * Request Reviewer AJAX
     */
    public function postReservation(Request $request)
    {
        $reservation_id = $this->reservation_util->getRequestIdForUserAsset($request->req_asset_id, $request->req_user_id);
        $this->reservation_util->acceptReservation($reservation_id);
    }

    public function rejectedReservation(Request $request)
    {
        $this->reservation_util->rejectReservation($this->reservation_util->getRequestIdForUserAsset($request->req_asset_id, $request->req_user_id));
    }

}