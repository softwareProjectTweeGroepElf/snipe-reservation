<?php
Route::group([ 'prefix'  => 'package' ], function() {
	//Route::get('/home', 'groepelf\reservatie\Http\ReservatieController@getIndex');
    Route::get('reservations/teacher', 'ReservationController@getViewTeacher');
});
