<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyWorkoutRoutinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('age_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('gender_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('measure_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });


        Schema::create('objective_tags', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
        });

        Schema::table('workout_routines', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('frequence_default')->unsigned();
            $table->integer('duration_default')->unsigned();

            $table->string('pubmed_link');

            $table->integer('age_tag_id')->unsigned();
            $table->foreign('age_tag_id')->references('id')->on('age_tags');

            $table->integer('gender_tag_id')->unsigned();
            $table->foreign('gender_tag_id')->references('id')->on('gender_tags');

            $table->integer('measure_tag_id')->unsigned();
            $table->foreign('measure_tag_id')->references('id')->on('measure_tags');

            $table->integer('sport_id')->unsigned();
            $table->foreign('sport_id')->references('id')->on('athlete_group_sports');

            $table->integer('objective_tag_id')->unsigned();
            $table->foreign('objective_tag_id')->references('id')->on('objective_tags');

        });

        Schema::table('workout_routine_translations', function (Blueprint $table) {
            $table->dropColumn('description_internal');
            $table->dropColumn('description_external');
            $table->dropColumn('title_internal');
            $table->dropColumn('title_external');

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('injuries')->nullable();
        });

        Schema::create('region_tag_workout_routine', function (Blueprint $table) {
            $table->integer('workout_routine_id')->unsigned()->index();
            $table->foreign('workout_routine_id')->references('id')->on('workout_routines');
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
        Schema::drop('region_tag_workout_routine');

        Schema::table('workout_routine_translations', function (Blueprint $table) {

            $table->dropColumn('title');
            $table->dropColumn('description');
            $table->dropColumn('injuries');

            $table->text('description_internal');
            $table->text('description_external');
            $table->string('title_internal');
            $table->string('title_external');
        });

        Schema::table('workout_routines', function (Blueprint $table) {

            $table->dropForeign('workout_routines_user_id_foreign');
            $table->dropColumn('user_id');

            $table->dropColumn('frequence_default');
            $table->dropColumn('duration_default');

            $table->dropColumn('pubmed_link');

            $table->dropForeign('workout_routines_objective_tag_id_foreign');
            $table->dropColumn('objective_tag_id');

            $table->dropForeign('workout_routines_sport_id_foreign');
            $table->dropColumn('sport_id');

            $table->dropForeign('workout_routines_measure_tag_id_foreign');
            $table->dropColumn('measure_tag_id');

            $table->dropForeign('workout_routines_age_tag_id_foreign');
            $table->dropColumn('age_tag_id');

            $table->dropForeign('workout_routines_gender_tag_id_foreign');
            $table->dropColumn('gender_tag_id');
        });

        Schema::drop('objective_tags');
        Schema::drop('measure_tags');
        Schema::drop('age_tags');
        Schema::drop('gender_tags');
    }
}
