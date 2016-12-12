<?php

/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 17/11/2016
 * Time: 23:53
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateReservationArchiveTable extends Migration
{

    public function up()
    {
        Schema::create('reservation_archive', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('asset_id');
            $table->dateTime('from')->nullable();
            $table->dateTime('until')->nullable();
            $table->dateTime('checked_in');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservation_archive');
    }

}