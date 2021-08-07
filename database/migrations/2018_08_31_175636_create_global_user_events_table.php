<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlobalUserEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_user_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('athlete_id')->unsigned();
            $table->foreign('athlete_id')->references('id')->on('athletes')->onDelete('cascade');
            $table->integer('event_type')->unsigned();
            $table->string('data');
            $table->bigInteger('client_time')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('global_user_events');
    }
}
