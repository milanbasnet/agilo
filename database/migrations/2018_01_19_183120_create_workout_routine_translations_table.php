<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutRoutineTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('workout_routine_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workout_routine_id')->unsigned();
            $table->foreign('workout_routine_id')->references('id')->on('workout_routines')->onDelete('cascade');
            $table->string('language_code', 2);
            $table->string('title_internal');
            $table->string('title_external');
            $table->text('description_internal');
            $table->text('description_external');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('workout_routine_translations');
    }
}
