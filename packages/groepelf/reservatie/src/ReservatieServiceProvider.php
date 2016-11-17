<?php
namespace groepelf\reservatie;

use Illuminate\Support\ServiceProvider;

class ReservatieServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('reservatie', function($app){
			return new reservatie;

		});


	}
	public function boot()
	{
		//loading routes file
		require __DIR__ . '/Http/routes.php';
	}


}