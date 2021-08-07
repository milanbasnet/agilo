<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('type_tag_workout', function (Blueprint $table) {
            $table->integer('workout_id')->unsigned()->index();
            $table->foreign('workout_id')->references('id')->on('workouts');
            $table->integer('type_tag_id')->unsigned()->index();
            $table->foreign('type_tag_id')->references('id')->on('type_tags');
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
        Schema::drop('type_tag_workout');
        Schema::drop('type_tags');
    }
}
