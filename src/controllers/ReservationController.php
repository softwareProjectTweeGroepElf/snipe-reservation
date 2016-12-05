<?php

namespace sp2gr11\reservation\controllers;

use App\Http\Controllers\Controller;
use sp2gr11\reservation\fetchers\ReservationFetcher;
use sp2gr11\reservation\util\CheckInUtil;
use sp2gr11\reservation\util\RoleUtil;
use sp2gr11\reservation\util\FineUtil;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ReservationController extends Controller
{
	//public functions
	public function __construct()
	{
		$this->middleware('auth');
	}

/*	public function getReservation()
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
	}*/

    /*public function postCheckIn($reservation_id)
    {
        $until_date = Carbon::createFromFormat('Y/m/d', DB::table('reservation_assets')->select('until')->where('id', $reservation_id)->first());
        CheckInUtil::CheckIn($reservation_id);

        if (Carbon::now()->diffInHours($until_date) < 0)
            return redirect()->action('ReservationController@getReservation');
        else
            return view('overtime')->with('fine', FineUtil::calculateFine($reservation_id));
    }*/

	public function getStudent()
	{
		return view('Reservation::requestreservation')->with('assets', ReservationFetcher::getAvailableAssets());
	}

	public function getProfessor()
	{
		if(RoleUtil::isUserReviewer())
			return view('Reservation::requestreview')->with('requestedassets', ReservationFetcher::getReservationRequests());
		else
			return redirect()->back();
	}

	public function getLeasingService()
	{
		if(RoleUtil::isUserLeasingService())
			return view('Reservation::lendingservice')->with('assets', ReservationFetcher::getAvailableAssets());
		else
			return redirect()->back();
	}



}