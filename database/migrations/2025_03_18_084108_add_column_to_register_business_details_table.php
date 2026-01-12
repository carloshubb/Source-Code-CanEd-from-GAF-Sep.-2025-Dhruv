<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('register_business_details', function (Blueprint $table) {
            $table->text('logo_lable',500)->nullable();
            $table->text('logo_placeholder',500)->nullable();
            $table->text('logo_error',500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('register_business_details', function (Blueprint $table) {
            $table->dropColumn('logo_lable');
            $table->dropColumn('logo_placeholder');
            $table->dropColumn('logo_error');
        });
    }
};
