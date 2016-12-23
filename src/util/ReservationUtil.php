<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 28/11/2016
 * Time: 10:35
 */

namespace sp2gr11\reservation\util;

use Carbon\Carbon;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;

class ReservationUtil
{

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getReservationIdForAsset($asset_id)
    {
        return $this->connection->table('reservation_assets')->select('id')
            ->where('asset_id', $asset_id)->first()->id;
    }

    public function getRequestIdForUserAsset($asset_id, $user_id)
    {
        return $this->connection->table('reservation_requests')->select('id')->where([
            'asset_id' => $asset_id,
            'user_id' => $user_id
        ])->first()->id;
    }

    public function isAssetOvertime($asset_id)
    {
        $reservation = $this->connection->table('reservation_assets')->where('asset_id', $asset_id)->first();

        return Carbon::parse($reservation->until)->isPast() ? true : false;
    }

    public function createReservationRequest($user_id, $asset_id)
    {
        $this->connection->table('reservation_requests')->insert([
            'asset_id' => $asset_id,
            'user_id' => $user_id,
        ]);
    }

    public function acceptReservation($reservation_id)
    {
        $reservation_request = $this->connection->table('reservation_requests')->where('id', $reservation_id)->first();

        $now = Carbon::now();

        $this->connection->table('reservation_assets')->insert([
            'asset_id' => $reservation_request->asset_id,
            'user_id' => $reservation_request->user_id,
            'from' => null,
            'until' => null
        ]);

        $this->connection->table('reservation_requests')->where('id', $reservation_id)->delete();
    }

    public function rejectReservation($reservation_id)
    {
        $reservation_request = $this->connection->table('reservation_requests')->where('id', $reservation_id)->first();

        $this->connection->table('reservation_archive')->insert([
            'asset_id' => $reservation_request->asset_id,
            'user_id' => $reservation_request->user_id,
        ]);

        $this->connection->table('reservation_requests')->where('id', $reservation_id)->delete();
    }
}