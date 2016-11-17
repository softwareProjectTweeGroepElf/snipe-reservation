<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Repositories\AssetRepository;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use App\Http\Requests;

class ApiController extends Controller
{
    private $assetRepository;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->assetRepository = new AssetRepository();
    }

    public function getAllAssets(Request $request){
    	return response()->json($this->assetRepository->getAll());
    }

    public function getAssetsById(Request $request, $id){
    	return response()->json($this->assetRepository->getById($id));
    }

    public function getAssetsFiltered(Request $request, $variable, $value){
		$var = $this->assetRepository->getAll();
		$save = array();
		if ($variable == "id"){
			$waarde = intval($value);
		}

		$localvar = 0;

		for ($i=0; $i <sizeof($var); $i++) { 
 			if($var[$i][$variable] == $value){			
 				$save[$localvar] = $var[$i];
 				$localvar += 1;
 			}
		}
		if ($save == null){
            return "Asset not found";
        }
        return response()->json($save);
	}

	public function deleteAssetById(Request $request, $id){
		
		if ($this->assetRepository->delete($assetId)){
		 	return "Succes!";
        }
		else{ 
            return "Failed";
        }
	}

	public function createAsset(Request $request){
			$asset = array(
		   		'name' => $request->input('name'),
		   		'serial' => $request->input('serial'),
				'asset_tag' => $request->input('asset_tag'), //string
                'model_id' => intval($request->input('model_id')),
                'purchase_date' => $request->input('purchase_date'),
                'purchase_cost' => intval($request->input('purchase_cost')),
                'order_number' => $request->input('order_number'),
                'notes' => $request->input('notes'),
                'image' => $request->input('image'),
                'user_id' => intval($request->input('user_id')),
                'status_id' => intval($request->input('status_id')),
                'physical'=> intval($request->input('physical')),
                'warranty_months' => $request->input('warranty_months'),
                'supplier_id' => intval($request->input('supplier_id')),
                'requestable' => $request->input('requestable'),
                'rtd_location_id' => intval($request->input('rtd_location_id')),
                'accepted' => $request->input('accepted'),
                'company_id' => intval($request->input('company_id'))
			);

		if ($this->assetRepository->create($asset)){
            return "<h1>Succes!</h1>";
        }
		else
        {
            return "<h1>Failed!</h1>";
        }
		
	}

	public function updateAsset(Request $request, $id){
		$asset = array(
		   		'name' => $request->input('name'),
		   		'serial' => $request->input('serial'),
				'asset_tag' => $request->input('asset_tag'), //string
                'model_id' => intval($request->input('model_id')),
                'purchase_date' => $request->input('purchase_date'),
                'purchase_cost' => intval($request->input('purchase_cost')),
                'order_number' => $request->input('order_number'),
                'notes' => $request->input('notes'),
                'image' => $request->input('image'),
                'user_id' => intval($request->input('user_id')),
                'status_id' => intval($request->input('status_id')),
                'physical'=> intval($request->input('physical')),
                'warranty_months' => $request->input('warranty_months'),
                'supplier_id' => intval($request->input('supplier_id')),
                'requestable' => $request->input('requestable'),
                'rtd_location_id' => intval($request->input('rtd_location_id')),
                'accepted' => $request->input('accepted'),
                'company_id' => intval($request->input('company_id'))
			);
		if ($this->assetRepository->update($asset, $id)){
            return "<h1>Succes!</h1>";
        }
        else
        {
            return "<h1>Failed!</h1>";
        }
	}
}



