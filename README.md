# snipe-reservation
### How to use
1. Install the package via composer (`composer require sp2gr11/reservation`)
2. Add `sp2gr11\reservation\providers\ReservationServiceProvider::class` to your providers array in app.php
3. Run the vendor publish command (`php artisan vendor:publish --provider=sp2gr11\reservation\providers\ReservationServiceProvider`)
4. Migrate (`php artisan migrate`) - this will create the tables necessary to use Reservation
