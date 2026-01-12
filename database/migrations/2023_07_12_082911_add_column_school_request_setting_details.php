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
        Schema::table('school_request_setting_details', function (Blueprint $table) {
            $table->text('description_label', 500)->nullable();
            $table->text('description_placeholder', 500)->nullable();
            $table->text('description_error', 500)->nullable();
            $table->text('city_label', 500)->nullable();
            $table->text('city_placeholder', 500)->nullable();
            $table->text('city_error', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
