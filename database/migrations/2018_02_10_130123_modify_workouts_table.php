<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyWorkoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workouts', function (Blueprint $table) {
            //
            $table->dropColumn('repetitions_split');

            //adding columns for default values
            $table->integer('sets_default')->unsigned();
            $table->integer('rest_default')->unsigned();
            $table->float('weight_default')->unsigned()->nullable();
            $table->integer('repetitions_default')->unsigned()->nullable();
            $table->integer('holding_period_default')->unsigned()->nullable();

            $table->string('material')->nullable();

        });

        Schema::table('parameterized_workouts', function (Blueprint $table) {
            //
            $table->dropColumn('repetitions_split_a');
            $table->dropColumn('repetitions_split_b');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parameterized_workouts', function (Blueprint $table) {
            //
            $table->string('repetitions_split_a')->nullable();
            $table->string('repetitions_split_b')->nullable();
        });

        Schema::table('workouts', function (Blueprint $table) {

            $table->dropColumn('material');

            $table->dropColumn('sets_default');
            $table->dropColumn('rest_default');
            $table->dropColumn('weight_default');
            $table->dropColumn('repetitions_default');
            $table->dropColumn('holding_period_default');

            $table->boolean('repetitions_split');
        });
    }
}
