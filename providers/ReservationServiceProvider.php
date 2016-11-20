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
			require  __DIR__ . '../routes/routes.php';
		}

		$this->loadMigrationsFrom( __DIR__ . '../migrations');
        $this->loadViewsFrom( __DIR__ . '../views', 'Reservation');

		$this->publishes([
            __DIR__ . '../config/reservation.php' => config_path('reservation.php'),
		]);
	}


}