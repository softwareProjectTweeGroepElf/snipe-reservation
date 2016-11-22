<?php
Route::group([ 'prefix'  => 'package' ], function() {
	Route::get('/home', 'groepelf\reservatie\Http\ReservatieController@getIndex');
	Route::get('/home2', 'groepelf\reservatie\Http\ReservatieController@getIndex2');

});