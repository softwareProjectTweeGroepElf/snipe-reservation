<?php
namespace sp2gr11\reservation\providers;

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
			require __DIR__ . '../routes/routes.php';
		}

        $this->loadViewsFrom(__DIR__ . '/../views', 'Reservation');

		$this->publishes([
			__DIR__ . '/../config/reservation.php' => config_path('reservation.php'),
		]); // CONFIG FILE

		$this->publishes([
			__DIR__ . '/../migrations' => database_path('migrations'),
		]); // MIGRATIONS

	}


}