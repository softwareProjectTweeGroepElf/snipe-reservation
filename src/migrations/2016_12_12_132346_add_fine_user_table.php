<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 10-12-2016
 * Time: 15:32
 */
class add_fine_user_table
{
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->integer('fine')->nullable();
        });
    }



    public function down()
    {
        Schema::dropIfExists('fine');
    }
}