<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 18/11/2016
 * Time: 1:00
 */

namespace Reservation\fetchers;

use Carbon\Carbon;
use Illuminate\Database\Connection;
use App\Models\Asset;
use App\Models\User;

class ReservationFetcher
{

    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getAvailableAssets()
    {
        $unavailable_assets_ids = $this->connection->table('reservation_assets')->pluck('asset_id');
        $assets = Asset::whereNotIn('id', $unavailable_assets_ids)->get();

        return $assets;
    }

    public function getReservationRequests()
    {
        $reservation_requests = $this->connection->table('reservation_requests')->get();

        foreach ($reservation_requests as $idx => $reservation_request)
        {
            $reservation_requests[$idx]->asset = Asset::find($reservation_request->asset_id);
            $reservation_requests[$idx]->user = User::find($reservation_request->user_id);
        }

        return $reservation_requests;
    }

    public function getLeasedAssets($date = null)
    {
        if(!$date)
            $reservations = $this->connection->table('reservation_assets')->get();
        else
            $reservations = $this->connection->table('reservation_assets')->where('from', $date)->get();

        foreach ($reservations as $idx => $reservation)
        {
            $reservations[$idx]->asset = Asset::find($reservation->asset_id);
            $reservations[$idx]->user = User::find($reservation->user_id);
        }

        return $reservations;

    }

    public function getEndDateLeasedAssets($date = null)
    {
        if(!$date)
            $reservations = $this->connection->table('reservation_assets')->get();
        else
            $reservations = $this->connection->table('reservation_assets')->where('until', $date)->get();

        foreach ($reservations as $idx => $reservation)
        {
            $reservations[$idx]->asset = Asset::find($reservation->asset_id);
            $reservations[$idx]->user = User::find($reservation->user_id);
        }

        return $reservations;
    }

    public function getLeasedAssetsExceptOvertime()
    {
        $assets = $this->connection->table('reservation_assets')->whereNotNull('from')->get();

        $assets_on_schedule = array();
        foreach($assets as $asset)
        {
            if(Carbon::parse($asset->until)->isFuture())
                $assets_on_schedule[] = $asset;
        }

        return $assets_on_schedule;
    }

    /**
     * @param User|int $user
     * @return A list of reservation requests made by the user
     */
    public function getRequestedAssetsForUser($user)
    {
        $user_id = is_int($user) ? $user : $user->id;

        $requested_assets = $this->connection->table('reservation_requests')->where('user_id', $user_id)->get();

        $user_requested_assets = array();
        foreach($requested_assets as $idx => $requested_asset)
        {
            $user_requested_assets[$idx] = $requested_assets[$idx];
            $user_requested_assets[$idx]->asset = Asset::find($requested_assets[$idx]->asset_id);
            $user_requested_assets[$idx]->user = is_int($user) ? User::find($user) : $user;
        }

        return $user_requested_assets;
    }
}