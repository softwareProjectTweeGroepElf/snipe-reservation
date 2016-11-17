<?php

namespace groepelf\reservatie\Http;
use App\Http\Controllers\Controller;
use App\Models\Asset;

class ReservatieController extends Controller
{
	public function getIndex(){
		return '<h1>Het werkt!</h1>';
	}
	public function getIndex2(){
		return '<h1>Het werkt ook!</h1>';
	}
	public function getIndex2(){
		return '<h1>Het werkt ook!</h1>';
	}

	public function getUnassignedAssets(){
		   $var =  Asset::all();
		   $save = array();
		   $localvar = 0;
		    for ($i=0; $i < count($var); $i++) { 
		    	if ($var[$i]["assigned_to"] == null  ){
		    	$save[$localvar] = $var[$i];
		    	$localvar += 1;
		   		}
		    }
		    return $save;
	}

	public function getAssetsAssignedToSpecificUser($id){
	 	    $var =  Asset::all();
		    $save = array();
		    $localvar = 0;
		    $id = intval($id);
		 	for ($i=0; $i < count($var); $i++) { 
		    	if ($var[$i]["assigned_to"] == $id){
		    		$save[$localvar] = $var[$i];
		    		$localvar += 1;
		   		}
		    }
		    return $save;	
	}


}