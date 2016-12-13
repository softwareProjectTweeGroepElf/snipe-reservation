<?php

namespace sp2gr11\reservation\controllers;

use App\Http\Controllers\Controller;
use sp2gr11\reservation\fetchers\ReservationFetcher;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ReservationController extends Controller
{
    private $reservation_fetcher;
    private $role_util;

	public function __construct(ReservationFetcher $reservation_fetcher, RoleUtil $role_util)
	{
		$this->middleware('auth');
		$this->reservation_fetcher = $reservation_fetcher;
	}

	public function getStudent()
	{
		return view('Reservation::requestreservation')->with([
			'assets' => $this->reservation_fetcher->getAvailableAssets(),
			'userassets' => $this->reservation_fetcher->getRequestedAssetsForUser(Auth::user())
		]);
	}

	public function getProfessor()
	{
		if($this->role_util->isUserReviewer())
			return view('Reservation::requestreview')->with('requestedassets', $this->reservation_fetcher->getReservationRequests());
		else
			return redirect()->back();
	}

	public function getLeasingService()
	{
		if($this->role_util->isUserLeasingService())
			return view('Reservation::lendingservice')->with('assets', $this->reservation_fetcher->getAvailableAssets());
		else
			return redirect()->back();
	}
}