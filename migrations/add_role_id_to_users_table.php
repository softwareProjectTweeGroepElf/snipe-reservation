<?php

/**
 * Created by PhpStorm.
 * User: Tanguy
 * Date: 17/11/2016
 * Time: 22:16
 */
use Illuminate\Database\Migrations\Migration;

class AddRoleIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function($table) {
            $table->integer('role_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('role_id');
        });
    }

}