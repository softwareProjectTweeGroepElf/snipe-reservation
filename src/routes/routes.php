
<?php
Route::group([ 'prefix'  => 'reservation' ], function() {
	//Route::get('/home', 'groepelf\reservatie\Http\ReservatieController@getIndex');
    Route::get('/students', 'sp2gr11\reservation\controllers\ReservationController@getStudent');
    Route::get('/professors', 'sp2gr11\reservation\controllers\ReservationController@getProfessor');
    Route::get('/lendingservice', 'sp2gr11\reservation\controllers\ReservationController@getLeasingService');
    Route::get('/config', 'sp2gr11\reservation\controllers\ReservationController@getConfig');
    /*Route::get('/getAssetForMonth', 'sp2gr11\reservation\controllers\AjaxController@getAssetReservationsForMonth');
    Route::get('/JavascriptCalender','sp2gr11\reservation\controllers\ReservationController@getJavascriptCalender');*/
    
    // USED BY AJAX CALLS
    Route::get('/lsaction', 'sp2gr11\reservation\controllers\AjaxController@lsaction'); // lending service
    Route::get('/initdoc', 'sp2gr11\reservation\controllers\AjaxController@getAssetIDandNames'); // student
    Route::get('/initdoclendservice', 'sp2gr11\reservation\controllers\AjaxController@getAllinfoLS'); // lending service
    Route::get('/postreservation', 'sp2gr11\reservation\controllers\AjaxController@postreservation'); // docent
    Route::get('/rejectreservation', 'sp2gr11\reservation\controllers\AjaxController@rejectedReservation'); // docent
    Route::get('/postrequestreservation', 'sp2gr11\reservation\controllers\AjaxController@postReservationRequest'); // student



    //TIJDELIJKE ROUTES VOOR MAILFUNCTIES
    Route::get('/mailReminder', 'sp2gr11\reservation\controllers\ReservationController@getMailReminder');
    Route::get('/mailSecondReminder', 'sp2gr11\reservation\controllers\ReservationController@getMailSecondReminder');
    Route::get('/mailOverview', 'sp2gr11\reservation\controllers\ReservationController@getMailDailyOverview');
    Route::get('/mailLendableAsset', 'sp2gr11\reservation\controllers\ReservationController@getMailLendableAsset');



});