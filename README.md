# snipe-reservation
### How to use
<<<<<<< HEAD
1. Install the package via composer
2. Run the migrations (php artisan:migrate)
3. Add `sp2gr11\reservation\ReservationServiceProvider::class,` to your `app.php`'s vendor service providers
4. Add ` "sp2gr11\\reservation\\": "vendor/sp2gr11/reservation/src" ` in composer.json of your project in the  psr-4": section (that is located in "autoload" )
=======
1. Install the package via composer (`composer require sp2gr11/reservation`)
2. Add `Reservation\Providers\ReservationServiceProvider::class` to your providers array in app.php
3. Run the vendor publish command (`php artisan vendor:publish --provider=Reservation\Providers\ReservationServiceProvider`)
4. Migrate (`php artisan migrate`) - this will create the tables necessary to use Reservation
>>>>>>> 03d6eb7800ba5dfb12541d30e6df9c38b58f1925
