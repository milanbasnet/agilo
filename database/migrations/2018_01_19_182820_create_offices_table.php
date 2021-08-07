<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('street');
            $table->string('zip_code');
            $table->string('city');
            $table->string('country');
            $table->string('phone');
            $table->string('email');
            $table->string('logo_path')->nullable();
            $table->longText('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('offices');
    }
}
