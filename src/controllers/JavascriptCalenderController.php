<?php
/**
 * Created by PhpStorm.
 * User: Tom-PC-School
 * Date: 5/12/2016
 * Time: 14:10
 */

namespace sp2gr11\reservation\controllers;
use App\Http\Controllers\Controller;
use sp2gr11\reservation\fetchers\ReservationFetcher;
use sp2gr11\reservation\util\CheckInUtil;
use sp2gr11\reservation\util\RoleUtil;
use sp2gr11\reservation\util\FineUtil;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JavascriptCalenderController extends Controller
{
    public function getJavascriptCalender()
    {
        //return view('calender.index');
        return view('Reservation::calender');
    }
}