<?php
Route::group([ 'prefix'  => 'reservation' ], function() {
	//Route::get('/home', 'groepelf\reservatie\Http\ReservatieController@getIndex');
    Route::get('/students', 'sp2gr11\reservation\controllers\ReservationController@getStudent');
    Route::get('/professors', 'sp2gr11\reservation\controllers\ReservationController@getProfessor');
    Route::get('/lendingservice', 'sp2gr11\reservation\controllers\ReservationController@getLeasingService');

    // USED BY AJAX CALLS
    Route::get('/lsaction', 'sp2gr11\reservation\controllers\AjaxController@lsaction');
    Route::get('/initdoc', 'sp2gr11\reservation\controllers\AjaxController@getAssetIDandNames');
    Route::get('/initdoclendservice', 'sp2gr11\reservation\controllers\AjaxController@getAllinfoLS');
    Route::get('/postreservation', 'sp2gr11\reservation\controllers\AjaxController@postreservation');
    Route::get('/rejectreservation', 'sp2gr11\reservation\controllers\AjaxController@rejectedReservation');
    Route::get('/postrequestreservation', 'sp2gr11\reservation\controllers\AjaxController@postReservationRequest');
});