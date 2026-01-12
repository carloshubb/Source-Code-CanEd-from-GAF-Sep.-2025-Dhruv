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
        Schema::table('admission_settings', function (Blueprint $table) {
            $table->string('admission_blue_bar_button_title')->nullable();
            $table->string('admission_blue_bar_button_link')->nullable();
            $table->string('admission_red_bar_button_title')->nullable();
            $table->string('admission_red_bar_button_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admission_settings', function (Blueprint $table) {
            $table->dropColumn('admission_blue_bar_button_title');
            $table->dropColumn('admission_blue_bar_button_link');
            $table->dropColumn('admission_red_bar_button_title');
            $table->dropColumn('admission_red_bar_button_link');
        });
    }
};
