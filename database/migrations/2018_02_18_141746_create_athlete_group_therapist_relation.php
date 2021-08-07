<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAthleteGroupTherapistRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('athlete_group_user', function (Blueprint $table) {
            $table->integer('athlete_group_id')->unsigned()->index();
            $table->foreign('athlete_group_id')->references('id')->on('athlete_groups')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::drop('athlete_group_user');
    }
}
