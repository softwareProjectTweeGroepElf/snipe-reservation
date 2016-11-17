<?php
//namespace sp2gr11\reservation;

use Illuminate\Support\ServiceProvider;

class ReservationServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('Reservation', function($app){
		return new Reservation();

		});


	}
	public function boot()
	{
		if (! $this->app->routesAreCached()) {
			require '../routes/routes.php';
		}

		$this->loadMigrationsFrom('../migrations');

        $this->loadViewsFrom('/views', 'Reservation');
	}


}