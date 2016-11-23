<?php
Route::group([ 'prefix'  => 'package' ], function() {
	Route::get('/home', function(){return "it works";});
	Route::get('/home2', 'sp2gr11\reservation\controllers\ReservationController@getIndex');
	Route::get('/home3', 'sp2gr11\reservation\controllers\ReservationController@getStudent');


	
});