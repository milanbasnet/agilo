<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::table('workouts', function (Blueprint $table) {
            $table->integer('level_tag_id')->unsigned();
            $table->foreign('level_tag_id')->references('id')->on('level_tags');
        });

        Schema::table('workout_routines', function (Blueprint $table) {
            $table->integer('level_tag_id')->unsigned();
            $table->foreign('level_tag_id')->references('id')->on('level_tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workout_routines', function (Blueprint $table) {
            $table->dropForeign('workout_routines_level_tag_id_foreign');
            $table->dropColumn('level_tag_id');
        });

        Schema::table('workouts', function (Blueprint $table) {
            $table->dropForeign('workouts_level_tag_id_foreign');
            $table->dropColumn('level_tag_id');
        });

        Schema::drop('level_tags');
    }
}
