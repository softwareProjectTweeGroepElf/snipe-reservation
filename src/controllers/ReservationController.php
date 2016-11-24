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


//use Illuminate\Routing\Controller;



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
    	    'asset_id' => $request->input('asset_id')   
        ])){$worked = true;}else{$worked = false;}
   		
   		//___________________DATA OPHALEN___________________________________


		$var =  Asset::all();
		for ($i=0; $i < sizeof($var); $i++) { 
			if (!$var[$i]["assigned_to"] == null){
				 unset($var[$i]);
			}
		}
		
		$var3 = DB::table('reservation_requests')->get();;
		
		for ($i=0; $i <sizeof($var3); $i++) { 
		
			$id = $var3[$i]->user_id;
			$Aid = $var3[$i]->asset_id;
		
    		$var3[$i]->name = User::where('id', $id)->get()[0]["first_name"]." ".User::where('id', $id)->get()[0]["last_name"];
			$var3[$i]->Aname = Asset::where('id', $Aid)->get()[0]["name"];
			
		}
		
		//__________________VIEW RETURNEN___________________________________
		if($worked == true)
   		{
   			$var2 = "Your request was submitted succesfully!";
       		return view('reservation::students')->with('succes', $var2)->with('assets', $var)->with('Rassets',$var3);
 	  	}
 	  	$var2 = "Whoops, something went wrong while submitting your request!";
		return view('reservation::students')->with('failed', $var2)->with('assets', $var)->with('Rassets',$var3);
		
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
		   // $request->input('user_id') = Auth::id();
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

	public function getIndex(){

		return "Reaching the controllers works aswell";
	}

	public function getStudent(){

		$var =  Asset::all();

		for ($i=0; $i < sizeof($var); $i++) { 
			if (!$var[$i]["assigned_to"] == null){
				 unset($var[$i]);
			}
		}
		
		$var3 = DB::table('reservation_requests')->get();;
		
		for ($i=0; $i <sizeof($var3); $i++) { 
		
			$id = $var3[$i]->user_id;
			$Aid = $var3[$i]->asset_id;
		
    		$var3[$i]->name = User::where('id', $id)->get()[0]["first_name"]." ".User::where('id', $id)->get()[0]["last_name"];
			$var3[$i]->Aname = Asset::where('id', $Aid)->get()[0]["name"];

		}
     
		return view('reservation::students')->with('assets', $var)->with('Rassets',$var3);
	}


}