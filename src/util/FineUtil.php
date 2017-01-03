<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 25/11/2016
 * Time: 9:16
 */

namespace sp2gr11\reservation\util;

use Carbon\Carbon;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;

class FineUtil
{

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function fine($reservation_id)
    {
        $reservation = Carbon::createFromFormat('Y/m/d', $this->connection->table('reservation_archive')->where('id', $reservation_id)->first());
        $diff = Carbon::now()->diffInHours(Carbon::parse($reservation->until));

        return $this->connection->table('users_fines')->insertGetId([
            'user_id' => $reservation->user_id,
            'reservation_id' => $reservation_id,
            'amount' => (round($diff * 0.20)),
            'paid' => 0,
        ]);
    }
}