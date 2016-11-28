<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21-11-2016
 * Time: 21:07
 */

namespace Reservation\Util;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckInUtil
{
        /*public static function CheckIn($reservation_id)
        {
            $reservation = DB::table('reservation_assets')->where('id', $reservation_id)->first();

            DB::table('reservation_archive')->insert([
                'user_id' => $reservation->user_id,
                'asset_id' => $reservation->asset_id,
                'from' => $reservation->from,
                'until' => $reservation->until,
                'checked_in' => Carbon::now(),
                'status' => 'ACCEPTED'
            ]);

            DB::table('reservation_assets')->where('id', $reservation_id)->delete();
        }*/

        public static function checkInByAssetId($asset_id)
        {
            $reservation = DB::table('reservation_assets')->where('asset_id', $asset_id)->first();

            DB::table('reservation_archive')->insert([
                'asset_id' => $reservation->asset_id,
                'user_id' => $reservation->user_id,
                'from' => $reservation->from,
                'until' => $reservation->until,
                'checked_in' => Carbon::now(),
            ]);

            DB::table('reservation_assets')->where('asset_id', $asset_id)->delete();
        }
}