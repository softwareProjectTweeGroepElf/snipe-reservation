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
	    return view('view.teacher');
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

    public function checkEndDateReservation(){
        $today = getdate();
        $reservation = DB::table('reservation_assets')->where('id');
    }

    public function getAllEndDateReservations(){
        $today = getdate();
        /*$reservation = DB::table('reservation_assets')->where([
            ['until'[year], $today[year]],
            ['until'[mon], $today[mon]],
            ['until'[mday], $today[mday]],
            ])->get();*/

        $reservations = DB::table('reservation_assets')
            ->whereDate('until', $today)
            ->get();
        return $reservations;
    }

    public function sendReminderMailToUsers(){

        $reservations = $this->getAllEndDateReservations();
        foreach ($reservations as $reservation)
        {
            $user_id = $reservation->user_id;
            $user = User::find($user_id);
            $to = $user->email;
            $subject = "Automatic reminder";
            $message = $user->name + "your Reservations ends tomorrow!";
            mail($to, $subject, $message);
        }
        /*
        //require_once 'lib/swift_required.php';

        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 25)
            ->setUsername('Admin')
            ->setPassword('Admin')
        ;


        You could alternatively use a different transport such as Sendmail or Mail:

        // Sendmail
        $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

        // Mail
        $transport = Swift_MailTransport::newInstance();


        //Create the email body message
        $data =

        // Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);

        // Create a message
        $message = Swift_Message::newInstance('Web Lead')
            ->setFrom(array('sam.van.roy@student.ehb.be' => 'Sam Van Roy'))
            ->setTo(array( 'other@domain.org' => 'A name'))
            ->setSubject('Automatic email from sam.van.roy@student.ehb.be')
            ->setBody()
        ;

        // Send the message
        $result = $mailer->send($message);
        */
    }
}