<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
        });

        Schema::table('parameterized_workouts', function (Blueprint $table) {
            $table->foreign('workout_id')->references('id')->on('workouts')->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles');
        });

        Schema::table('workouts', function (Blueprint $table) {
            $table->integer('video_id')->unsigned();
            $table->foreign('video_id')->references('id')->on('videos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {

        Schema::table('workouts', function (Blueprint $table) {
            $table->dropForeign('workouts_video_id_foreign');
            $table->dropColumn('video_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_role_id_foreign');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_office_id_foreign');
        });

        Schema::table('parameterized_workouts', function (Blueprint $table) {
            $table->dropForeign('parameterized_workouts_workout_id_foreign');
        });
    }
}
