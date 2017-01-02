<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21-11-2016
 * Time: 21:24
 */

namespace sp2gr11\reservation\util;

use Carbon\Carbon;
use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder;

class CheckOutUtil
{

    /**
     * @var Connection
     */
    private $connection;

    /**
     * CheckOutUtil constructor.
     * @param Builder $builder
     */
    public function __construct(Connection  $connection)
    {

        $this->connection = $connection;
    }

   /* public static function checkOut($reservation_id)
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
    }*/

    public function checkOutByAssetId($asset_id)
    {
        $now = new Carbon();
        $now2 = new Carbon(); 
        $this->connection->table('reservation_assets')->where('asset_id', $asset_id)->update(['from' => $now, 'until' => $now2->addMonth()]);
    }

}