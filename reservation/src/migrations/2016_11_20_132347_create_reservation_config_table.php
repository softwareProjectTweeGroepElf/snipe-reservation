<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
// Created by lupix. All rights reserved.

class CreateReservationConfigTable
{
    public function up()
    {
        Schema::create('reservation_config', function(Blueprint $table) {
            $table->increments('id');
            $table->string('option');
            $table->string('value');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservation_config');
    }
}