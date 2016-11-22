<?php

/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 17/11/2016
 * Time: 23:01
 */
use Illuminate\Database\Migrations\Migration;

class CreateReservationTable extends Migration
{
    public function up()
    {
        Schema::create('reservation_assets', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('asset_id');
            $table->dateTime('from');
            $table->dateTime('until');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservation_assets');
    }
}