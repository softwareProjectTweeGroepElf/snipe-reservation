<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 28/11/2016
 * Time: 10:35
 */

namespace sp2gr11\reservation\util;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReservationUtil
{
    public static function getReservationIdForAsset($asset_id)
    {
        return DB::table('reservation_assets')->select('id')
            ->where('asset_id', $asset_id)->first()->id;
    }

    public static function getRequestIdForUserAsset($asset_id, $user_id)
    {
        return DB::table('reservation_requests')->select('id')->where([
            'asset_id' => $asset_id,
            'user_id' => $user_id
        ])->first()->id;
    }

    public static function createReservationRequest($user_id, $asset_id)
    {
        DB::table('reservation_requests')->insert([
            'asset_id' => $asset_id,
            'user_id' => $user_id,
        ]);
    }

    public static function acceptReservation($reservation_id)
    {
        $reservation_request = DB::table('reservation_requests')->where('id', $reservation_id)->first();

        $now = Carbon::now();

        DB::table('reservation_assets')->insert([
            'asset_id' => $reservation_request->asset_id,
            'user_id' => $reservation_request->user_id,
            'from' => null,
            'until' => null
        ]);

        DB::table('reservation_requests')->where('id', $reservation_id)->delete();
    }

    public static function rejectReservation($reservation_id)
    {
        $reservation_request = DB::table('reservation_requests')->where('id', $reservation_id)->first();

        DB::table('reservation_archive')->insert([
            'asset_id' => $reservation_request->asset_id,
            'user_id' => $reservation_request->user_id,
        ]);

        DB::table('reservation_requests')->where('id', $reservation_id)->delete();
    }
}