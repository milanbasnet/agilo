<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToOffice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_sport', function (Blueprint $table) {
            $table->integer('office_id')->unsigned()->index();
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->integer('sport_id')->unsigned()->index();
            $table->foreign('sport_id')->references('id')->on('athlete_group_sports')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('office_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('i18n');
        });

        Schema::table('offices', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->string('contact');

            $table->integer('office_type_id')->unsigned();
            $table->foreign('office_type_id')->references('id')->on('office_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->dropForeign('offices_office_type_id_foreign');
            $table->dropColumn('office_type_id');
            $table->dropColumn('contact');
            $table->longText('description');
        });

        Schema::drop('office_types');

        Schema::drop('office_sport');
    }
}
