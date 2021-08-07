<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleInAppFieldToWorkoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workout_translations', function (Blueprint $table) {
            $table->string('title_in_app');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workout_translations', function (Blueprint $table) {
            $table->dropColumn('title_in_app');
        });
    }
}
