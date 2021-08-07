<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParameterizedWorkoutsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('parameterized_workouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workout_id')->unsigned();
            $table->integer('workout_routine_id')->unsigned();
            $table->foreign('workout_routine_id')->references('id')->on('workout_routines')->onDelete('cascade');
            $table->integer('sets')->unsigned()->nullable();
            $table->integer('repetitions')->unsigned()->nullable();
            $table->string('repetitions_split_a')->nullable();
            $table->string('repetitions_split_b')->nullable();
            $table->string('rest')->nullable();
            $table->string('holding_period')->nullable();
            $table->string('weight')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('parameterized_workouts');
    }
}
