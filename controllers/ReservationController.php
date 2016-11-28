<?php

namespace Reservation\Controllers;

use App\Http\Controllers\Controller;
use Reservation\Fetchers\ReservationFetcher;
use Reservation\Util\CheckInUtil;
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
		return view('reservation::requestreservation')->with('assets', ReservationFetcher::getAvailableAssets());
	}

	public function getProfessor()
	{
		return view('reservation::requestreview')->with('requestedassets', ReservationFetcher::getReservationRequests());
	}

	public function getLeasingService()
	{
		return view('reservation::lendingservice')->with('assets', ReservationFetcher::getAvailableAssets());
	}



}