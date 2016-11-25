<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21-11-2016
 * Time: 21:24
 */

namespace Reservation\Util;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckOutUtil
{
    public static function checkOut($reservation_id)
    {
        $reservation = DB::table('reservation_requests')->where('id', $reservation_id)->first();
        $until_date = Carbon::now()->addWeek();

        DB::table('reservation_assets')->insert([
            'user_id' => $reservation->user_id,
            'asset_id' => $reservation->asset_id,
            'from' => Carbon::now(),
            'until' => $until_date
        ]);

        DB::table('reservation_requests')->where('id', $reservation_id)->delete();
    }

}