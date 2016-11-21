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


    public function calculateFine($assetId)
    {
        $result=DB::table('reservation_assets')->select('until')->first();
        $currentDate= date("m.d.y");

        strtotime($currentDate);
        strtotime($result);


        $verschil=$currentDate-$result;

        $verschil=$verschil/86400;

        $verschil = floor($verschil);
        return $boeteBedrag=$verschil*50;
    }


    public function checkDate($assetId)
    {
        $result=DB::select('select expected_checkin from assets where id=$assetId');
        $currentDate= time();

        if ($result<$currentDate)
        {
            return "Asset Checked in";
            //Hier moet nog de functie komen om een item in te checken.
        }
        else
        {
            $fine=calculateFine($assetId);
            return view('teLaat')->with('fine', $fine);
        }
    }



}