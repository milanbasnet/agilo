<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutRoutinesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('workout_routines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id')->unsigned();
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('workout_routines');
    }
}
