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
use sp2gr11\reservation\util\CheckOutUtil;
use sp2gr11\reservation\util\CheckInUtil;
use sp2gr11\reservation\util\ReservationUtil;
use sp2gr11\reservation\util\FineUtil;
use sp2gr11\reservation\fetchers\ReservationFetcher;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function lsaction(Request $request){
        $asset_id = $request->asset_id;
        $action =  $request->asset_action;

        if($action == "checkout"){
            CheckOutUtil::checkOutByAssetId($asset_id);
        }
        elseif ($action == "checkin") {
            CheckInUtil::checkInByAssetId($asset_id);
            return "Succesfully checked asset with ID ". $asset_id." in.";
        }
        elseif ($action == "overtime") {
            CheckInUtil::checkInByAssetId($asset_id);
            $fine = FineUtil::calculateFine(ReservationUtil::getReservationIdForAsset($asset_id));
            return "Succesfully checked asset with ID ". $asset_id." in. The asset was too late, user has a fine of " . $fine;
        }

        return "select a legitimate action!";
    }

    public function getAssetIDandNames(){
        $free_assets = ReservationFetcher::getAvailableAssets();
        $data = array();

        foreach($free_assets as $asset)
            array_push($data, ['id' => $asset->id, 'name' => $asset->name]);

        return $data;
    }

    public function getAllinfoLS(){
        $available_assets = ReservationFetcher::getAvailableAssets();
        $lent_assets = ReservationFetcher::getLeasedAssets();
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

    public function postReservation(Request $request)
    {
        $reservation_id = ReservationUtil::getRequestIdForUserAsset($request->req_asset_id, $request->req_user_id);
        ReservationUtil::acceptReservation($reservation_id);
    }

    public function postReservationRequest(Request $request){
        ReservationUtil::createReservationRequest(Auth::user()->id, $request->asset_id);
        return true;
    }
}