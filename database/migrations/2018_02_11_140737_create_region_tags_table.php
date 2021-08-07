<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
        });

        Schema::create('region_tag_workout', function (Blueprint $table) {
            $table->integer('workout_id')->unsigned()->index();
            $table->foreign('workout_id')->references('id')->on('workouts');
            $table->integer('region_tag_id')->unsigned()->index();
            $table->foreign('region_tag_id')->references('id')->on('region_tags');
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
        Schema::drop('region_tag_workout');
        Schema::drop('region_tags');
    }
}
