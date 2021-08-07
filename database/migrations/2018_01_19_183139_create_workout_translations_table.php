<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('workout_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workout_id')->unsigned();
            $table->foreign('workout_id')->references('id')->on('workouts')->onDelete('cascade');
            $table->string('language_code', 2);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('workout_translations');
    }
}
