<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 25/11/2016
 * Time: 9:16
 */

namespace Reservation\util;

use Carbon\Carbon;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;

class FineUtil
{

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = connection;
    }

    public function calculateFine($reservation_id)
    {
        $until_date = Carbon::createFromFormat('Y/m/d', $this->connection->table('reservation_assets')->select('until')->where('id', $reservation_id)->first());
        $diff = Carbon::now()->diffInHours($until_date);

        return round($diff * 0.20, 2);
    }
}