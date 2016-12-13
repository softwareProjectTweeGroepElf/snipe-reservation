
<?php
Route::group([ 'prefix'  => 'reservation' ], function() {
	//Route::get('/home', 'groepelf\reservatie\Http\ReservatieController@getIndex');
    Route::get('/students', 'sp2gr11\reservation\controllers\ReservationController@getStudent');
    Route::get('/professors', 'sp2gr11\reservation\controllers\ReservationController@getProfessor');
    Route::get('/lendingservice', 'sp2gr11\reservation\controllers\ReservationController@getLeasingService');
    Route::get('/JavascriptCalAjax', 'sp2gr11\reservation\controllers\AjaxController@getLeasedAssetsExceptOvertime');
    Route::get('/JavascriptCalender','sp2gr11\reservation\controllers\ReservationController@getJavascriptCalender');
    
    // USED BY AJAX CALLS
    Route::get('/lsaction', 'sp2gr11\reservation\controllers\AjaxController@lsaction'); // lending service
    Route::get('/initdoc', 'sp2gr11\reservation\controllers\AjaxController@getAssetIDandNames'); // student
    Route::get('/initdoclendservice', 'sp2gr11\reservation\controllers\AjaxController@getAllinfoLS'); // lending service
    Route::get('/postreservation', 'sp2gr11\reservation\controllers\AjaxController@postreservation'); // docent
    Route::get('/rejectreservation', 'sp2gr11\reservation\controllers\AjaxController@rejectedReservation'); // docent
    Route::get('/postrequestreservation', 'sp2gr11\reservation\controllers\AjaxController@postReservationRequest'); // student



});