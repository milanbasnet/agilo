<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecoveryCodeFieldToTableAthletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('athletes', function (Blueprint $table) {
            //
            $table->string('recovery_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('athletes', function (Blueprint $table) {
            //
            $table->dropColumn('recovery_code');

        });
    }
}
