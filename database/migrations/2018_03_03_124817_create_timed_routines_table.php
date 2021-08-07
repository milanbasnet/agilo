<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimedRoutinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_routines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('frequence')->unsigned();
            $table->integer('duration')->unsigned();
            $table->date('start_date');

            $table->integer('routine_id')->unsigned();
            $table->foreign('routine_id')->references('id')->on('workout_routines');

            $table->integer('group_id')->nullable()->unsigned();
            $table->foreign('group_id')->references('id')->on('athlete_groups');

            $table->integer('athlete_id')->nullable()->unsigned();
            $table->foreign('athlete_id')->references('id')->on('athletes');
            $table->timestamps();
        });

        Schema::drop('athlete_group_workout_routine');
        Schema::drop('athlete_workout_routine');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::create('athlete_workout_routine', function (Blueprint $table) {
            $table->integer('athlete_id')->unsigned()->index();
            $table->foreign('athlete_id')->references('id')->on('athletes')->onDelete('cascade');
            $table->integer('workout_routine_id')->unsigned()->index();
            $table->foreign('workout_routine_id')->references('id')->on('workout_routines')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('athlete_group_workout_routine', function (Blueprint $table) {
            $table->integer('athlete_group_id')->unsigned()->index();
            $table->foreign('athlete_group_id')->references('id')->on('athlete_groups')->onDelete('cascade');
            $table->integer('workout_routine_id')->unsigned()->index();
            $table->foreign('workout_routine_id')->references('id')->on('workout_routines')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::drop('assigned_routines');
    }
}
