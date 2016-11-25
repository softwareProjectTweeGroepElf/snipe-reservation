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


    public function checkDate($reservation_id)
    {
        $until_date = Carbon::createFromFormat('Y/m/d', DB::table('reservation_assets')->select('until')->where('id', $reservation_id)->first());

        if (!$until_date->isPast())
            CheckInUtil::CheckIn($reservation_id);
        else
        {
            $fine = FineUtil::calculateFine($reservation_id);
            return view('teLaat')->with('fine', $fine);
        }
    }



}