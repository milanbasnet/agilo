<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutTagsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('workout_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->timestamps();
        });

        Schema::create('workout_workout_tag', function (Blueprint $table) {
            $table->integer('workout_id')->unsigned()->index();
            $table->foreign('workout_id')->references('id')->on('workouts')->onDelete('cascade');
            $table->integer('workout_tag_id')->unsigned()->index();
            $table->foreign('workout_tag_id')->references('id')->on('workout_tags')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('workout_workout_tag');
        Schema::drop('workout_tags');
    }
}
