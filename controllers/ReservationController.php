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
	    return view('view-teacher');
    }

    public function getAllReservations(){
        if(RoleUtil::isUserReviewer())
            return view('view-teacher')->with('reservations', ReservationFetcher::getReservationRequests());
        else
            return redirect()->back();
    }

    public static function acceptReservation(Request $request){
        $reservation = DB::table('reservation_requests')->where('id', $request->reservation_id)->first();
        DB::table('reservation_assets')->insert(['user_id' => $reservation->user_id, 'asset_id' => $reservation->asset_id, 'from' => $reservation->from, 'until' => $reservation->until]);
        DB::table('reservation_requests')->where('id', $request->reservation_id)->delete();
        if(DB::table('assets')
            ->select('assigned_to')
            ->where('id', $request->asset_id)->get() === null)
        {
        DB::table('assets')
            ->where('id', $request->asset_id)
            ->update(['assigned_to' => $request->user_id]);
        }
    }

    public static function rejectReservation(Request $request){
        $reservation = DB::table('reservation_requests')->where('id', $request->reservation_id)->first();
        DB::table('reservation_archive')->insert(['user_id' => $reservation->user_id, 'asset_id' => $reservation->asset_id, 'from' => $reservation->from, 'until' => $reservation->until, 'status' => 'DENIED']);
        DB::table('reservation_requests')->where('id', $request->reservation_id)->delete();
    }

    public function getAllAssetsReadyForLoaning(){
        $today = getdate();
        $reservations = DB::table('reservation_assets')
            ->whereDate('from', $today)
            ->get();
        return $reservations;
    }

    public function getAllReservations1DayBeforeEndDate(){
        $today = getdate() + strtotime('-1 days');
        $reservations = DB::table('reservation_assets')
            ->whereDate('until', $today)
            ->get();
        return $reservations;
    }
    public function getAllEndDateReservations(){
        /*$reservation = DB::table('reservation_assets')->where([
            ['until'[year], $today[year]],
            ['until'[mon], $today[mon]],
            ['until'[mday], $today[mday]],
            ])->get();*/
        $today = getdate();
        $reservations = DB::table('reservation_assets')
            ->whereDate('until', $today)
            ->get();
        return $reservations;
    }
    public static function sendResultDecisionTeacherToStudent($decision, $reservation){
        $student_id = $reservation->user_id;
        $student = User::find($student_id);
        $student_asset_id = $reservation->asset_id;
        $student_asset = DB::table('assets')->where('id', $student_asset_id);

        $data = array();
        $data['first_name'] = $student->first_name;
        $data['last_name'] = $student->last_name;
        $data['asset_name'] = $student_asset->name;
        if($decision)
        {
            $data['decision'] = 'accepted';
        }
        else {
            $data['decision'] = 'denied';
        }
        Mail::send('emails.resultDecisionTeacher', $data ,function ($m) use ($student) {
            $m->to($student->email, $student->first_name . ' ' . $student->last_name);
            $m->subject('Decision teacher about your asset');
        });

    }

    public function sendDailyOverviewToHeadOfTheLendingService(){
        $reservations = $this->getAllAssetsReadyForLoaning();
        $reservation_asset = null;
        $reservation_user = null;
        /*foreach ($reservations as $reservation)
        {
            $reservation_asset_id = $reservation->asset_id;
            $reservation_asset = DB::table('assets')->where('id', $reservation_asset_id);
            $reservation_user_id = $reservation->user_id;
            $reservation_user = DB::table('users')->where('id', $reservation_user_id);
            $data['first_name'] .= $reservation_user->first_name;
            $data['last_name'] .= $reservation_user->last_name;
            $data['asset_name'] .= $reservation_asset->name;
        }*/

        Mail::send('emails.overviewDailyLendableAssets', $reservations ,function ($m) use ($reservation_user) {
            $m->to(config('mail.from.address'), config('mail.from.name'));
            $m->subject('Overview today \'s lendable assets');
        });
    }

    public function sendReminderMailToUsers(){
        $reservations = $this->getAllReservations1DayBeforeEndDate();
        $data = array();
        foreach ($reservations as $reservation) {
            $user_id = $reservation->user_id;
            $user = User::find($user_id);
            $user_asset_id = $reservation->asset_id;
            $user_asset = DB::table('assets')->where('id', $user_asset_id);

            $data['first_name'] = $user->first_name;
            $data['last_name'] = $user->last_name;
            $data['asset_name'] = $user_asset->name;

            Mail::send('emails.reminderMailUser', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Automatic reminder ending loan period asset');
            });
        }
    }

    //2e herinnering voor te zeggen dat het te laat is & dat er een boete volgt.

    public function sendSecondReminderMailToUsers(){
        $reservations = $this->getAllEndDateReservations();
        $data = array();
        foreach ($reservations as $reservation) {
            $user_id = $reservation->user_id;
            $user = User::find($user_id);
            $user_asset_id = $reservation->asset_id;
            $user_asset = DB::table('assets')->where('id', $user_asset_id);

            $data['first_name'] = $user->first_name;
            $data['last_name'] = $user->last_name;
            $data['asset_name'] = $user_asset->name;

            Mail::send('emails.secondReminderMailUser', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Automatic reminder loan period ended!');
            });
        }
    }

//De student zal een email ontvangen dat zijn gereserveerde item klaar ligt op de uitleendienst.
    public function sendEmailToStudentWhenAssetIsReadyForLoan(){
        $reservations = $this->getAllAssetsReadyForLoaning();
        $data = array();

        foreach ($reservations as $reservation) {
            $user_id = $reservation->user_id;
            $user = User::find($user_id);
            $user_asset_id = $reservation->asset_id;
            $user_asset = DB::table('assets')->where('id', $user_asset_id);

            $data['first_name'] = $user->first_name;
            $data['last_name'] = $user->last_name;
            $data['asset_name'] = $user_asset->name;

            Mail::send('emails.assetIsReadyForLoan', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->subject('Your asset is ready for loan!');
            });
        }
    }
}