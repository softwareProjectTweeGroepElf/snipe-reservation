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

    public static function getLeasedAssetsExceptOvertime()
    {
        $assets = DB::table('reservation_assets')->whereNotNull('from')->get();

        $assets_on_schedule = array();
        foreach($assets as $asset)
        {
            if(Carbon::parse($asset->from)->isFuture())
                $assets_on_schedule[] = $asset;
        }

        return $assets_on_schedule;
    }

    /**
     * @param User|int $user
     * @return A list of reservation requests made by the user
     */
    public static function getRequestedAssetsForUser($user)
    {
        $user_id = is_int($user) ? $user : $user->id;

        $requested_assets = DB::table('reservation_requests')->where('user_id', $user_id)->get();

        $user_requested_assets = array();
        foreach($requested_assets as $idx => $requested_asset)
        {
            $user_requested_assets[$idx] = $requested_assets[$idx];
            $user_requested_assets[$idx]->asset = Asset::find($requested_assets[$idx]->asset_id);
            $user_requested_assets[$idx]->user = is_int($user) ? User::find($user) : $user;
        }

        return $user_requested_assets;
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