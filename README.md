# snipe-reservation
### How to use
1. Install the package via composer
2. Run the migrations (php artisan:migrate)
3. Add `sp2gr11\reservation\ReservationServiceProvider::class,` to your `app.php`'s vendor service providers
4. Add ` "sp2gr11\\reservation\\": "vendor/sp2gr11/reservation/src" ` in composer.json of your project in the  psr-4": section (that is located in "autoload" )
