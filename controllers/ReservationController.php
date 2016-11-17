<?php

namespace Reservation\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\User;

class ReservationController extends Controller
{
	
	public function getAvailableAssets()
	{
		$assets = Asset::select()->whereNotIn('id', function($query) {
			$query->table('reservation_assets')->select('asset_id')->get();
		})->get();

		return $assets;
	}
}