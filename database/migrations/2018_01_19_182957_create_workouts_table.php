<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id')->unsigned();
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->string('image_path');
            $table->integer('type')->unsigned();
            $table->boolean('equipment_needed');
            $table->boolean('repetitions_split');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('workouts');
    }
}
