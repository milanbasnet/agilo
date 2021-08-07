<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAthleteGroupWorkoutRoutineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('athlete_group_workout_routine', function (Blueprint $table) {
            $table->integer('athlete_group_id')->unsigned()->index();
            $table->foreign('athlete_group_id')->references('id')->on('athlete_groups')->onDelete('cascade');
            $table->integer('workout_routine_id')->unsigned()->index();
            $table->foreign('workout_routine_id')->references('id')->on('workout_routines')->onDelete('cascade');
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
        Schema::drop('athlete_group_workout_routine');
    }
}
