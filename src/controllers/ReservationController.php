<?php

namespace sp2gr11\reservation\controllers;

use App\Http\Controllers\Controller;
use Reservation\Fetchers\ReservationFetcher;
use Reservation\Util\RoleUtil;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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


	public function postReservationRequest(Request $request)
	{
	///__________________DE INSERT_____________________________________
		if(DB::table('reservation_requests')->insert([
	        'user_id'=> Auth::id(),
    	    'asset_id' => $request->asset_id 
        ])){
			$worked = true;
		}
		else{
			$worked = false;
		}

	///__________________INSERTED VALUE RETURNEN___________________________________
		
		if($worked == true){
   			$user_requested_assets = self::getUserAssets();
			$temp = sizeof($user_requested_assets);
			$temp = $temp - 1;
			$inserted_user = $user_requested_assets[$temp];

			$newarray = Array();

			$newarray[0] = $inserted_user->user_id;
			$newarray[1] = $inserted_user->asset_id;
			$newarray[2] = $inserted_user->name;
			$newarray[3] = $inserted_user->Aname;
			return $newarray;
 	  	}
 		return false;
	}

	public function postReservation(Request $request)
	{
		if (!RoleUtil::isUserLeasingService()){
			return redirect()->back();
		}
		else{
			if(DB::table('reservation_assets')->insert([
			        'user_id'=> $request->input('user_id'),
	        	    'asset_id' => $request->input('asset_id'),
	        	    'from' => date('Y-m-d', strtotime($request->input('from'))),
	           		'until' => date('Y-m-d', strtotime($request->input('until')))  
	            ]))
	        {
	            return true;
	        }
			return false;
		}
	}

	public function getIndex(){
		return "Reaching the controllers works aswell";
	}

	public function getStudent(){
		return view('reservation::students')->with('assets', self::getFreeAssets())->with('userassets',self::getUserAssets());
	}

	public function getFreeAssets() {

		$free_assets =  Asset::all();

		for ($i=0; $i < sizeof($free_assets); $i++) { 
			if (!$free_assets[$i]["assigned_to"] == null){
				 unset($free_assets[$i]);
			}
		}
	return $free_assets;
	}

	public function getUserAssets($amount = 0) {
		
		$reservation_requests = DB::table('reservation_requests')->get();
		
		for ($i=0; $i <sizeof($reservation_requests); $i++) { 
			
			$user = User::where('id', $reservation_requests[$i]->user_id)->get()[0];
			$asset = Asset::where('id', $reservation_requests[$i]->asset_id)->get()[0]["name"];

    		$reservation_requests[$i]->name = $user["first_name"]." ".$user["last_name"];
			$reservation_requests[$i]->Aname = $asset;

		}
	return $reservation_requests;
	}

	public function getAssetIDs(){

		$free_assets =  Asset::all();
		$free_asset_id = Array();

		for ($i=0; $i <sizeof($free_assets) ; $i++) { 

			array_push($free_asset_id, $free_assets[$i]["id"]);

		}
	return $free_asset_id;
	}
}