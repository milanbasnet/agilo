<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthRecordsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('health_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('athlete_id')->unsigned();
            $table->foreign('athlete_id')->references('id')->on('athletes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('health_records');
    }
}