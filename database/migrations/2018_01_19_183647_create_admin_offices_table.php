<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminOfficesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('admin_offices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id')->unsigned();
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('admin_offices');
    }
}
