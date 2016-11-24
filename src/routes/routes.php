<?php
Route::group([ 'prefix'  => 'package' ], function() {
	Route::get('/test', function(){return "it works";});
	Route::get('/test2', 'sp2gr11\reservation\controllers\ReservationController@getIndex');
	Route::get('/students', 'sp2gr11\reservation\controllers\ReservationController@getStudent');
	Route::post('/students', 'sp2gr11\reservation\controllers\ReservationController@postReservationRequest');
});