<?php
Route::group([ 'prefix'  => 'reservation' ], function() {
	//Route::get('/home', 'groepelf\reservatie\Http\ReservatieController@getIndex');
    Route::get('/students', 'ReservationController@getStudent');
    Route::get('/professors', 'ReservationController@getProfessor');
    Route::get('/lendingservice', 'ReservationController@getLservice');

    // USED BY AJAX CALLS
    Route::get('/lsaction', 'ReservationController@lsaction');
    Route::get('/initdoc', 'ReservationController@getAssetIDandNames');
    Route::get('/initdoclendservice', 'ReservationController@getAllinfoLS');
    Route::get('/postreservation', 'ReservationController@postreservation');
    Route::get('/rejectreservation', 'ReservationController@rejectedReservation');
    Route::get('/postrequestreservation', 'ReservationController@postReservationRequest');
});