<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 18/11/2016
 * Time: 1:00
 */

namespace sp2gr11\reservation\fetchers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;
use App\Models\User;

class ReservationFetcher
{
    public static function getAvailableAssets()
    {
        $unavailable_assets_ids = DB::table('reservation_assets')->pluck('asset_id');
        $assets = Asset::whereNotIn('id', $unavailable_assets_ids)->get();

        return $assets;
    }

    public static function getReservationRequests()
    {
        $reservation_requests = DB::table('reservation_requests')->get();

        foreach ($reservation_requests as $idx => $reservation_request)
        {
            $reservation_requests[$idx]->asset = Asset::find($reservation_request->asset_id);
            $reservation_requests[$idx]->user = User::find($reservation_request->user_id);
        }

        return $reservation_requests;
    }

    public static function getLeasedAssets($date = null)
    {
        if(!$date)
            $reservations = DB::table('reservation_assets')->get();
        else
            $reservations = DB::table('reservation_assets')->where('from', $date)->get();

        foreach ($reservations as $idx => $reservation)
        {
            $reservations[$idx]->asset = Asset::find($reservation->asset_id);
            $reservations[$idx]->user = User::find($reservation->user_id);
        }

        return $reservations;
    }

    public static function getAllAssetsReadyForLoaning(){
        $now = Carbon::now();
        $date_string = $now->toDateString();
        $reservations = DB::table('reservation_assets')
            ->where('from', $date_string)
            ->get();
        return $reservations;
    }

    public static function getAllReservations1DayBeforeEndDate(){
        $yesterday = Carbon::yesterday();
        $date_string = $yesterday->toDateString();
        $reservations = DB::table('reservation_assets')
            ->where('until', $date_string)
            ->get();
        return $reservations;
    }
    public static function getAllEndDateReservations(){
        $today = Carbon::now();
        $date_string = $today->toDateString();
        $reservations = DB::table('reservation_assets')
            ->where('until', $date_string)
            ->get();
        return $reservations;
    }
}