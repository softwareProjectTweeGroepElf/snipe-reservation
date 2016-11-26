<?php
Route::group([ 'prefix'  => 'package' ], function() {

	// TESTS: ROUTE TEST & CONTROLLER TEST
	Route::get('/test', function(){return "it works";});
	Route::get('/test2', 'sp2gr11\reservation\controllers\ReservationController@getIndex');

	// MAIN ROUTES
	Route::get('/students', 'sp2gr11\reservation\controllers\ReservationController@getStudent');
	Route::get('/professors', 'sp2gr11\reservation\controllers\ReservationController@getProfessor');
	Route::get('/lendingservice', 'sp2gr11\reservation\controllers\ReservationController@getLservice');

	// USED BY AJAX CALLS
	Route::get('/lsaction', 'sp2gr11\reservation\controllers\ReservationController@lsaction');
	Route::get('/initdoc', 'sp2gr11\reservation\controllers\ReservationController@getAssetIDandNames');
	Route::get('/initdoclendservice', 'sp2gr11\reservation\controllers\ReservationController@getAllinfoLS');		
	Route::get('/postreservation', 'sp2gr11\reservation\controllers\ReservationController@postreservation');
	Route::get('/rejectreservation', 'sp2gr11\reservation\controllers\ReservationController@rejectedReservation');
	Route::get('/postrequestreservation', 'sp2gr11\reservation\controllers\ReservationController@postReservationRequest');


});