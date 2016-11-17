<?php
/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 7/11/2016
 * Time: 10:58
 */

namespace App\Repositories;


use App\Contracts\RepositoryContract as RepositoryContract;
use App\Models\Asset;
use Carbon\Carbon;

class AssetRepository implements RepositoryContract
{
    public function create($asset)
    {
        if(!Asset::find($asset['id']))
        {
            Asset::create([
                'name' => $asset['name'],
                'asset_tag' => $asset['asset_tag'],
                'model_id' => $asset['model_id'],
                'purchase_date' => $asset['purchase_date'],
                'purchase_cost' => $asset['purchase_cost'],
                'order_number' => $asset['order_number'],
                'notes' => $asset['notes'],
                'image' => $asset['image'],
                'user_id' => $asset['user_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
                'status_id' => $asset['status_id'],
                'archived' => null,
                'warranty_months' => $asset['warranty_months'],
                'depreciate' => null,
                'supplier_id' => $asset['supplier_id'],
                'requestable' => $asset['requestable'],
                'rtd_location_id' => $asset['rtd_location_id'],
                'accepted' => $asset['accepted'],
                'last_checkout' => null,
                'expected_checkin' => null,
                'company_id' => $asset['company_id']
            ]);
        }
        else
            return;
    }

    public function delete($id)
    {
        if($asset = Asset::find($id))
        {
            $asset->delete();
            return true;
        }
        else
            return false;
    }

    public function update($asset)
    {
        if(Asset::find($asset['id']))
        {
            $asset->save();
            return true;
        }
        else
            return false;
    }

    public function getById($id)
    {
        return Asset::find($id);
    }

    public function getAll()
    {
        return Asset::all();
    }

}