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

	public function getViewTeacher(){
	    return view('teacher');
    }

    public function getAllReservations(){
        if(RoleUtil::isUserReviewer())
            return view('view.teacher')->with('reservations', ReservationFetcher::getReservationRequests());
        else
            return redirect()->back();
    }

    public static function acceptReservation(Request $request){
        $reservation = DB::table('reservation_requests')->where('id', $request->reservation_id)->first();
        DB::table('reservation_assets')->insert(['user_id' => $reservation->user_id, 'asset_id' => $reservation->asset_id, 'from' => $reservation->from, 'until' => $reservation->until]);
        DB::table('reservation_requests')->where('id', $request->reservation_id)->delete();
    }

    public static function rejectReservation(Request $request){
        $reservation = DB::table('reservation_requests')->where('id', $request->reservation_id)->first();
        DB::table('reservation_archive')->insert(['user_id' => $reservation->user_id, 'asset_id' => $reservation->asset_id, 'from' => $reservation->from, 'until' => $reservation->until, 'status' => 'DENIED']);
        DB::table('reservation_requests')->where('id', $request->reservation_id)->delete();
    }
}