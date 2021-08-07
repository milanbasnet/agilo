<?php
/**
 * Created by PhpStorm.
 * User: ep1stle
 * Date: 11.02.18
 * Time: 12:55
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentsTable extends Migration
{
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::table('workouts', function (Blueprint $table) {
            $table->dropColumn('material');

            $table->integer('equipment_id')->unsigned()->nullable();
            $table->foreign('equipment_id')->references('id')->on('equipments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('workouts', function (Blueprint $table) {
            $table->dropForeign('workouts_equipment_id_foreign');
            $table->dropColumn('equipment_id');

            $table->string('material')->nullable();
        });

        Schema::drop('equipments');
    }
}