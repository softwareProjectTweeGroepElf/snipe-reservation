<?php

namespace Reservation\Controllers;

use App\Http\Controllers\Controller;
use Reservation\Fetchers\ReservationFetcher;
use Reservation\Util\CheckInUtil;
use Reservation\Util\CheckOutUtil;
use Reservation\Util\RoleUtil;
use Reservation\Util\FineUtil;
use App\Models\Asset;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
	//private functions



	//public functions
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getReservation()
	{
		return view('reservation')->with('assets', ReservationFetcher::getAvailableAssets());
	}

	public function getReservationRequests()
	{
		if (!RoleUtil::isUserReviewer())
			return redirect()->back();
		else
			return view('reservationrequests')->with('requests', ReservationFetcher::getReservationRequests());
	}

	public function getLeasingService()
	{
		if (!RoleUtil::isUserLeasingService())
			return redirect()->back();
		else
		return view('leasingservice')->with([
			['leasedAssets' => ReservationFetcher::getLeasedAssets()],
		]); // will add more variables to send
	}

    public function postCheckIn($reservation_id)
    {
        $until_date = Carbon::createFromFormat('Y/m/d', DB::table('reservation_assets')->select('until')->where('id', $reservation_id)->first());
        CheckInUtil::CheckIn($reservation_id);

        if (Carbon::now()->diffInHours($until_date) < 0)
            return redirect()->action('ReservationController@getReservation');
        else
            return view('overtime')->with('fine', FineUtil::calculateFine($reservation_id));
    }

	public function getStudent()
	{
		return view('requestreservation')->with('assets', ReservationFetcher::getAvailableAssets());
	}

	public function postReservationRequest(Request $request){

		///__________________THE INSERT_____________________________________
		DB::table('reservation_requests')->insert([
			'user_id'=> Auth::user()->id,
			'asset_id' => $request->asset_id
		]);
		return true;
	}

	public function getAssetIDandNames(){
		$free_assets = ReservationFetcher::getAvailableAssets();
		return $free_assets->pluck('id', 'name')->all();
	}

	public function getAllinfoLS(){
		$free_assets =  Asset::all();
		$free_asset_combo = Array();
		$free_asset_name_id = Array();
		$all_users = User::all();
		$free_users_combo = Array();
		$free_users_name_id = Array();
		$users_asset_combo = Array();
		for ($i=0; $i <sizeof($free_assets) ; $i++) {
			unset($free_asset_combo);
			$free_asset_combo = Array();
			array_push($free_asset_combo, $free_assets[$i]["id"], $free_assets[$i]["name"]);
			array_push($free_asset_name_id, $free_asset_combo);
		}
		for ($i=0; $i <sizeof($all_users) ; $i++){
			unset($free_users_combo);
			$free_users_combo = Array();
			array_push($free_users_combo, $all_users[$i]["id"], $all_users[$i]["first_name"]." ".$all_users[$i]["last_name"]);
			array_push($free_users_name_id, $free_users_combo);
		}
		$return_array = Array();
		array_push($return_array, $free_asset_name_id, $free_users_name_id);
		return $return_array;
	}

	/*public function lsaction(Request $request){
		$asset_id = $request->asset_id;
		$action =  $request->asset_action;
		$user_id = $request->user_id;
		if($action == "checkout"){

			CheckOutUtil::checkOut();
		}
		elseif ($action == "checkin") {
			if ($status == null){return "ERROR: ASSET IS ALREADY IN THE INVENTORY";}
			DB::table('assets')
				->where('id', $asset_id)
				->update(['assigned_to' => null]);
			return "Succesfully checked asset with ID ". $asset_id." in.";

		}
		elseif ($action == "overtime") {
			if ($status == null){return "ERROR: ASSET IS ALREADY IN THE INVENTORY";}
			DB::table('assets')
				->where('id', $asset_id)
				->update(['assigned_to' => null]);
			//INSERT FINE CALC OR SMTN
			return "Succesfully checked asset with ID ". $asset_id." in. The asset was too late, fine will be sent";
		}
		else{
			return "select a legitimate action!";
		}*/
	}

}