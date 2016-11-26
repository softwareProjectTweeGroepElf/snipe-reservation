<?php
Route::group([ 'prefix'  => 'package' ], function() {
	Route::get('/test', function(){return "it works";});
	Route::get('/test2', 'sp2gr11\reservation\controllers\ReservationController@getIndex');
	Route::get('/students', 'sp2gr11\reservation\controllers\ReservationController@getStudent');
	Route::get('/professors', 'sp2gr11\reservation\controllers\ReservationController@getProfessor');
	Route::get('/postrequestreservation', 'sp2gr11\reservation\controllers\ReservationController@postReservationRequest');
	Route::get('/initdoc', 'sp2gr11\reservation\controllers\ReservationController@getAssetIDandNames');
	Route::get('/postreservation', 'sp2gr11\reservation\controllers\ReservationController@postreservation');
	Route::get('/rejectreservation', 'sp2gr11\reservation\controllers\ReservationController@rejectedReservation');

});