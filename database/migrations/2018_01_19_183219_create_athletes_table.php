<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAthletesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('athletes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id')->unsigned();
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth');
            $table->string('email')->unique();
            $table->char('sex', 1);
            $table->string('password', 60);
            $table->string('language_code', 2);
            $table->boolean('active')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('athlete_workout_routine', function (Blueprint $table) {
            $table->integer('athlete_id')->unsigned()->index();
            $table->foreign('athlete_id')->references('id')->on('athletes')->onDelete('cascade');
            $table->integer('workout_routine_id')->unsigned()->index();
            $table->foreign('workout_routine_id')->references('id')->on('workout_routines')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('athlete_workout_routine');
        Schema::drop('athletes');
    }
}

