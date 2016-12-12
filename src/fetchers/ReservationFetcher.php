<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 18/11/2016
 * Time: 1:00
 */

namespace  sp2gr11\reservation\Fetchers;

use App\Models\Asset;
use Illuminate\Support\Facades\DB;

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
        return DB::table('reservation_requests')->get();
    }

    public static function getLeasedAssets()
    {
        return DB::table('reservation_assets')->get();
    }


}