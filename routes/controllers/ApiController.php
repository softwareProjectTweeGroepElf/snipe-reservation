<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Repositories\AssetRepository;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Http\Requests;

class ApiController extends Controller
{
    private $assetRepository;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->assetRepository = new AssetRepository();
    }

    public function getAllAssets(Request $request)
    {
        return response()->json($this->assetRepository->getAll());
    }
    public function getCreate(Request $request)
    {
        return response()->json($this->assetRepository->create($request));
    }
}
