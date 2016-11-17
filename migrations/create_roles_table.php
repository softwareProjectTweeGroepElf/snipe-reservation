<?php

/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 17/11/2016
 * Time: 22:10
 */

use Illuminate\Database\Migrations\Migration;
class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('reservation_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservation_roles');
    }

}