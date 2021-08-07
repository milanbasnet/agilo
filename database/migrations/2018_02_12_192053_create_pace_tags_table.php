<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaceTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pace_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::table('workouts', function (Blueprint $table) {
            $table->integer('pace_tag_id')->unsigned();
            $table->foreign('pace_tag_id')->references('id')->on('pace_tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workouts', function (Blueprint $table) {
            $table->dropForeign('workouts_pace_tag_id_foreign');
            $table->dropColumn('pace_tag_id');
        });
        Schema::drop('pace_tags');
    }
}
