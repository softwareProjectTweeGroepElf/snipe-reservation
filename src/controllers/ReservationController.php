<?php

namespace Reservation\Controllers;

use App\Http\Controllers\Controller;
use Reservation\Fetchers\ReservationFetcher;
use Reservation\Util\RoleUtil;
use App\Models\Asset;
use App\Models\User;

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
		
		if(DB::table('reservation_requests')->insert([
	        'user_id'=> $request->input('user_id'),
    	    'asset_id' => $request->input('asset_id')   
        ]))
   		{
       		return true;
 	  	}
		return false;
		
		/*
		if (reservation_requests::create(Request::All())){
			return true;
		}
		return false;
		*/
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

		/*if (reservation_assets::create(Request::All())){
			return true;
		}
		return false; */
	}

}