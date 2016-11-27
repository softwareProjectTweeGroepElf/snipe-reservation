<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 18/11/2016
 * Time: 1:00
 */

namespace Reservation\Fetchers;

use Illuminate\Support\Facades\DB;
use App\Models\Asset;
use App\Models\User;

class ReservationFetcher
{
    public static function getAvailableAssets()
    {
        $assets = Asset::select()->whereNotIn('id', function($query) {
            $query->table('reservation_assets')->select('asset_id')->get();
        })->get();

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
            $reservation[$idx]->asset = Asset::find($reservation->asset_id);
            $reservation[$idx]->user = User::find($reservation->user_id);
        }

        return $reservations;
    }
}