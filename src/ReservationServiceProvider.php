<?php
//namespace Reservation\Providers;
namespace sp2gr11\reservation;

//use Illuminate\Support\ServiceProvider;

use Illuminate\Support\ServiceProvider as BBaseServiceProvider;


class ReservationServiceProvider extends BBaseServiceProvider
{
	public function register()
	{
		$this->app->bind('Reservation', function($app){
			return new Reservation();
		});
	}


	public function boot()
	{

		//$this->loadRoutesFrom(__DIR__.'/../../routes.php');


		if (! $this->app->routesAreCached()) {
			require __DIR__ . '../routes/routes.php';
		}

		$this->loadViewsFrom(__DIR__ . '../views', 'Reservation');
		//$this->loadMigrationsFrom(__DIR__ . '../migrations');
  
		$this->publishes([
			__DIR__ . '../config/reservation.php' => config_path('reservation.php'),
		]);

	}




}