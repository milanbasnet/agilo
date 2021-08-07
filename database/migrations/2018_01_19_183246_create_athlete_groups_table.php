<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAthleteGroupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('athlete_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id')->unsigned();
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->string('title');
            $table->string('description')->nullable();
            $table->tinyInteger('workouts_per_week')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('athlete_athlete_group', function (Blueprint $table) {
            $table->integer('athlete_id')->unsigned()->index();
            $table->foreign('athlete_id')->references('id')->on('athletes')->onDelete('cascade');
            $table->integer('athlete_group_id')->unsigned()->index();
            $table->foreign('athlete_group_id')->references('id')->on('athlete_groups')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('athlete_athlete_group');
        Schema::drop('athlete_groups');
    }
}
