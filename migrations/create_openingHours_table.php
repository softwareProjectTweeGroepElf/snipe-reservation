<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 22-11-2016
 * Time: 19:44
 */
class create_openingHours_table
{
    public function up()
    {
        Schema::create('openingHours',function (Blueprint $table)
        {
           $table->unique->String ('Day')->default('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
            $table->String ('openingHours')->nullable();
            $table->String ('closingHours')->nullable();
            $table->dateTime('start');
            $table->dateTime('until')->default('start+7776000');
        });
    }

    public function down()
    {
        Schema::dropIfExists('openingHours');
    }
}