<?php

use Illuminate\Database\Schema\Blueprint;
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 10-12-2016
 * Time: 15:32
 */
class CreateFinesTable
{
    public function up()
    {
        Schema::create('users_fines', function (Blueprint$table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('reservation_id');
            $table->float('amount');
            $table->boolean('paid');
        });
    }



    public function down()
    {
        Schema::dropIfExists('users_fines');
    }
}