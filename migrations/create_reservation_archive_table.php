<?php

/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 17/11/2016
 * Time: 23:53
 */

use Illuminate\Database\Migrations\Migration;

class CreateReservationArchiveTable extends Migration
{

    public function up()
    {
        Schema::create('reservation_archive', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('asset_id');
            $table->dateTime('from');
            $table->dateTime('until');
            $table->enum('status', [ 'ACCEPTED', 'DENIED' ] );
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservation_requests');
    }

}