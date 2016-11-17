<?php
//namespace sp2gr11\reservation;

use Illuminate\Support\ServiceProvider;

class ReservationServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('reservation', function($app){
		return new reservation;

		});


	}
	public function boot()
	{
		require '/Http/routes.php';
		$this->loadMigrationsFrom('/migrations');

        $this->loadViewsFrom('/Views', 'reservation');
	}


}