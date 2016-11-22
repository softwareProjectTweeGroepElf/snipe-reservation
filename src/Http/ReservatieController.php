<?php

namespace groepelf\reservatie\Http;
use App\Http\Controllers\Controller;

class ReservatieController extends Controller
{
	public function getIndex(){
		return '<h1>Het werkt!</h1>';
	}
	public function getIndex2(){
		return '<h1>Het werkt ook!</h1>';
	}
}