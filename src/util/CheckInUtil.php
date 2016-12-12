<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21-11-2016
 * Time: 21:07
 */

namespace Reservation\util;

use Carbon\Carbon;
use Illuminate\Database\Connection;

class CheckInUtil
{
    private $connection;

    /**
     * CheckInUtil constructor.
     * @param Connection $
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function checkInByAssetId($asset_id)
    {
        $reservation = $this->connection->table('reservation_assets')->where('asset_id', $asset_id)->first();
        $insert_id = $this->connection->table('reservation_archive')->insertGetId([
            'asset_id'   => $reservation->asset_id,
            'user_id'    => $reservation->user_id,
            'from'       => $reservation->from,
            'until'      => $reservation->until,
            'checked_in' => Carbon::now(),
        ]);

        $this->connection->table('reservation_assets')->where('asset_id', $asset_id)->delete();

        return $insert_id;
    }
}