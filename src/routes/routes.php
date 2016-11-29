<?php
Route::group([ 'prefix'  => 'package' ], function() {
	//Route::get('/home', 'groepelf\reservatie\Http\ReservatieController@getIndex');
    Route::get('/students', 'ReservationController@getStudent');
    Route::get('/professors', 'ReservationController@getProfessor');
    Route::get('/lendingservice', 'ReservationController@getLeasingService');

    // USED BY AJAX CALLS
    Route::get('/lsaction', 'AjaxController@lsaction');
    Route::get('/initdoc', 'AjaxController@getAssetIDandNames');
    Route::get('/initdoclendservice', 'AjaxController@getAllinfoLS');
    Route::get('/postreservation', 'AjaxController@postreservation');
    Route::get('/rejectreservation', 'AjaxController@rejectedReservation');
    Route::get('/postrequestreservation', 'AjaxController@postReservationRequest');

    // USED FOR CRON JOB
    Route::get('/cronjob', 'CronjobController@schedule');

});