<?php

/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 17/11/2016
 * Time: 23:11
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateReservationRequestsTable extends Migration
{

    public function up()
    {
        Schema::create('reservation_requests', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('asset_id');
            $table->string('subject', 40);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservation_requests');
    }

}