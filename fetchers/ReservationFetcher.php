<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 18/11/2016
 * Time: 1:00
 */

namespace Reservation\Fetchers;

use App\Models\Asset;

class ReservationFetcher
{
    public static function getAvailableAssets()
    {
        $assets = Asset::select()->whereNotIn('id', function($query) {
            $query->table('reservation_assets')->select('asset_id')->get();
        })->get();

        return $assets;
    }
}