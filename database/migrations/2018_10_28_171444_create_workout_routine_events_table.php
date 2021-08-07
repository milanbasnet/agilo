<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutRoutineEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workout_routine_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('athlete_id')->unsigned();
            $table->foreign('athlete_id')->references('id')->on('athletes')->onDelete('cascade');
            $table->integer('assigned_routine_id')->unsigned();
            $table->foreign('assigned_routine_id')->references('id')->on('assigned_routines')->onDelete('cascade');
            $table->integer('event_type')->unsigned();
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
        Schema::drop('workout_routine_events');
    }
}
