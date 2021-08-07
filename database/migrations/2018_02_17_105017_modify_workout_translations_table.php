<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyWorkoutTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workout_translations', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->string('starting_position');
            $table->string('execution');
            $table->string('hints')->nullable();
            $table->string('difficulty')->nullable();
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
            $table->dropColumn('starting_position');
            $table->dropColumn('execution');
            $table->dropColumn('hints');
            $table->dropColumn('difficulty');
            $table->text('description');
        });
    }
}
