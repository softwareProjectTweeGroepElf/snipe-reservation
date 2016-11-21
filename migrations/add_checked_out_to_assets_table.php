<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21-11-2016
 * Time: 21:01
 */
class add_checked_out_to_assets_table extends Migration
{
    public function up()
    {
        Schema::table('assets', function($table) {
            $table->boolean('checked_out');
        });
    }

    public function down()
    {
        Schema::table('checked_out', function($table) {
            $table->dropColumn('checked_out');
        });
    }

}