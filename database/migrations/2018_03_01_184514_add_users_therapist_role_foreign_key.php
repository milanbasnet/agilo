<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersTherapistRoleForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('therapist_role_id')->unsigned()->nullable();
            $table->foreign('therapist_role_id')->references('id')->on('therapist_roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_therapist_role_id_foreign');
            $table->dropColumn('therapist_role_id');
        });
    }
}
