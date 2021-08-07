<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAthleteGroupRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('athlete_groups', function (Blueprint $table) {
            $table->integer('level_id')->unsigned();
            $table->foreign('level_id')->references('id')->on('athlete_group_levels');
            $table->integer('sport_id')->unsigned();
            $table->foreign('sport_id')->references('id')->on('athlete_group_sports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('athlete_groups', function (Blueprint $table) {
            $table->dropForeign('athlete_groups_level_id_foreign');
            $table->dropColumn('level_id');
            $table->dropForeign('athlete_groups_sport_id_foreign');
            $table->dropColumn('sport_id');
        });
    }
}
