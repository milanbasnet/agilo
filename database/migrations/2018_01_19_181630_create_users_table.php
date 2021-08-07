<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('active')->default(true);
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('phone')->nullable();
            $table->string('language_code', 2);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('users');
    }
}
