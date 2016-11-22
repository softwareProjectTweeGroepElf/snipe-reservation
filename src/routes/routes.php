<?php
Route::group([ 'prefix'  => 'packagee' ], function() {
	Route::get('/homee', function(){return "it works";});
	
});