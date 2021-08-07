<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBillingAddressToOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->boolean('active')->default(true);
            $table->boolean('has_billing_address')->default(0);
            $table->string('billing_name')->nullable();
            $table->string('billing_street')->nullable();
            $table->string('billing_zip_code')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_country')->nullable();
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
            $table->dropColumn('billing_name');
            $table->dropColumn('billing_street');
            $table->dropColumn('billing_zip_code');
            $table->dropColumn('billing_city');
            $table->dropColumn('billing_country');
            $table->dropColumn('active');
            $table->dropColumn('has_billing_address');
        });
    }
}
