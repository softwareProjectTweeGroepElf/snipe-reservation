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

	// STILL NEED TO CHECK FOR EVERY FUNCTION THE USERS AUTHORITY (e.g. STUDENT CANT ACCEPT/REJECT REQUESTS(OR EVEN SEE THAT PAGE FOR THAT MATTER))

	//private functions



	//public functions
	public function __construct()
	{
		$this->middleware('auth');
	}

	// (!!FOR NOW!!) UNUSED FUNCTIONS

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
	
	// FUNCTIONS WHO RETURN VIEWS

	public function getIndex(){
		return "Reaching the controllers works aswell";
	}

	public function getStudent(){
		return view('reservation::students')->with('assets', self::getFreeAssets())->with('userassets',self::getUserAssets());
	}

	public function getProfessor(){
		return view('reservation::professors')->with('requestedassets', self::getRequestedAssets());
	}
	public function getLservice(){
		return view('reservation::lendingservice')->with('assets', self::getFreeAssets());
	}

	// DB INTERACTIONFUNCTIONS, HAS TO BE MOVED TO FETCHERS IN FUTURE
	// GET FUNCTIONS

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
		
		$reservation_requests = DB::table('requested_assets')->get();
		
		for ($i=0; $i <sizeof($reservation_requests); $i++) { 
			
			$user = User::where('id', $reservation_requests[$i]->user_id)->get()[0];
			$asset = Asset::where('id', $reservation_requests[$i]->asset_id)->get()[0]["name"];

    		$reservation_requests[$i]->name = $user["first_name"]." ".$user["last_name"];
			$reservation_requests[$i]->Aname = $asset;

		}
		return $reservation_requests;
	}

	public function getAssetIDandNames(){

		$free_assets =  Asset::all();
		$free_asset_combo = Array();
		$free_asset_name_id = Array();

		for ($i=0; $i <sizeof($free_assets) ; $i++) { 

			unset($free_asset_combo);
			$free_asset_combo = Array();
			array_push($free_asset_combo, $free_assets[$i]["id"], $free_assets[$i]["name"]);
			array_push($free_asset_name_id, $free_asset_combo);

		}
		return $free_asset_name_id;
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

	public function getRequestedAssets(){

		$reservation_requests = DB::table('requested_assets')->get();

		for ($i=0; $i <sizeof($reservation_requests); $i++) { 

			$user = User::where('id', $reservation_requests[$i]->user_id)->get()[0];
			$asset = Asset::where('id', $reservation_requests[$i]->asset_id)->get()[0]["name"];

    		$reservation_requests[$i]->name = $user["first_name"]." ".$user["last_name"];
			$reservation_requests[$i]->Aname = $asset;
		}
		return $reservation_requests;
	}

	// POST FUNCTIONS

	public function postReservation(Request $request)
	{	
		$to_submit_request_id = $request->req_asset_id;
		
		// if (!RoleUtil::isUserLeasingService()){
		// 	return redirect()->back();
		// }
		// else{
		//var_dump($to_submit_request_id);

		DB::table('reservation_assets')->insert([
		        'user_id'=> 1,//$request->input('user_id'),
        	    'asset_id' => $to_submit_request_id, //,
        	    'from' => date('Y-m-d', strtotime($request->input('from'))), //THESE TWO DATA FUNCTIONS ARE USELESS (INSERT GIBBERISH VALUES, NEED TO BE CHANGED)
           		'until' => date('Y-m-d', strtotime($request->input('until')))  
            ]);

		DB::table('requested_assets')->where('asset_id',$to_submit_request_id)->delete();

		return "succes";
	}


	public function postReservationRequest(Request $request){
		
	///__________________THE INSERT_____________________________________

		if(DB::table('requested_assets')->insert([
	        'user_id'=> Auth::id(),
    	    'asset_id' => $request->asset_id 
        ])){
			$worked = true;
		}
		else{
			$worked = false;
		}

	///__________________ RETURN INSERTED VALUE ___________________________________
		
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

	public function lsaction(Request $request){

		$asset_id = $request->asset_id;
        $asset_tag = $request->asset_tag;
		$action =  $request->asset_action;
		$user_id = $request->user_id;
        $expected_checkin =DB::table('assets')->where('asset_tag', $asset_tag)->get()[0]->expected_checkin;
        $today = date('Y/m/d');
        $expected= date('Y/m/d',strtotime(('-1 week')));




		$status = DB::table('assets')->where('asset_tag', $asset_tag)->get()[0]->assigned_to;

		if($status == null){
			


			DB::table('assets')
            ->where('asset_tag', $asset_tag)
            ->update(['assigned_to' => $user_id,'expected_checkin'=>$expected]);

            $asset = DB::table('assets')->where('asset_tag', $asset_tag)->first();
            $user = DB::table('users')->where('id',$user_id)->first();


            return "Succesfully assigned asset ". $asset->name ." to ". $user->first_name;
		}
		elseif ($status != null && $expected_checkin>$today) {



			DB::table('assets')
            ->where('id', $asset_id)
            ->update(['assigned_to' => null,'expected_checkin'=>null]);

            $asset = DB::table('assets')->where('asset_tag', $asset_tag)->first();

           return "Succesfully checked asset with ID ". $asset->name." in.";
			
		}
		elseif ($status!=null&& $expected_checkin<$today) {


            $daysLate=round(abs(strtotime($today)-strtotime(($expected_checkin))));
            $daysLate=$daysLate/60/60/24;
            $fine = $daysLate*2;



			DB::table('assets')
            ->where('id', $asset_id)
            ->update(['assigned_to' => null,'expected_checkin'=>null]);


/*
            DB::table('users')
            ->where('id',$user_id)
            ->update(['fine' => $fine]);
*/





            $asset = DB::table('assets')->where('asset_tag', $asset_tag)->first();
            $user = DB::table('users')->where('id',$user_id)->first();

			return "Succesfully checked asset ". $asset->name." in. The asset was too late, a fine of $fine euro  will be sent";
		}
		else{

			return "select a legitimate action!";

		}

	}

	// THIS FUNCTION IS FOR DELETING RESERVATION OUT OF REQUESTS, STILL NEED TO ARCHIVE

	public function rejectedReservation(Request $request)
	{
		$to_delete_request_asset_id = $request->req_asset_id;
		$to_delete_request_user_id = $request->req_user_id;

		DB::table('requested_assets')
		->where([['user_id','=',$to_delete_request_user_id],['asset_id','=',$to_delete_request_asset_id]])
		->delete();

		return "succes";
	}

}