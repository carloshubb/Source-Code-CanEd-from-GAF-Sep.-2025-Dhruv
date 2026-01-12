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
        Schema::table('master_application_setting_details', function (Blueprint $table) {
            $table->text('school_lable', 500)->nullable();
            $table->text('school_error', 500)->nullable();
            $table->text('school_placeholder', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_application_setting_details', function (Blueprint $table) {
            //
        });
    }
};
