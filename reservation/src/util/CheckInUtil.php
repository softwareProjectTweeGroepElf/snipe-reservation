<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21-11-2016
 * Time: 21:07
 */

namespace sp2gr11\reservation\util;

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
        $reservation = $this->connection->table('reservation_assets')->get();
        
        $x;
        for ($i=0; $i < count($reservation) ; $i++) { 
            if ($reservation[$i]->asset_id == $asset_id){
                $x = $i;
            }
        }

        

        $insert_id = $this->connection->table('reservation_archive')->insertGetId([
            'asset_id'   => $reservation[$x]->asset_id,
            'user_id'    => $reservation[$x]->user_id,
            'from'       => $reservation[$x]->from,
            'until'      => $reservation[$x]->until,
            'checked_in' => Carbon::now()->addHour(),
        ]);

        $this->connection->table('reservation_assets')->where('asset_id', $asset_id)->delete();

        return $insert_id;
    }
}