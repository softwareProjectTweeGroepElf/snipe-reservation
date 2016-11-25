<?php
Route::group([ 'prefix'  => 'package' ], function() {
	Route::get('/test', function(){return "it works";});
	Route::get('/test2', 'sp2gr11\reservation\controllers\ReservationController@getIndex');
	Route::get('/students', 'sp2gr11\reservation\controllers\ReservationController@getStudent');
	Route::post('/postrequestreservation', 'sp2gr11\reservation\controllers\ReservationController@postReservationRequest');
	Route::get('/initdoc', 'sp2gr11\reservation\controllers\ReservationController@getAssetIDs');
});