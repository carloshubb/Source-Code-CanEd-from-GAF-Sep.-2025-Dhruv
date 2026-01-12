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
        Schema::table('scholarship_settings', function (Blueprint $table) {
            $table->string('scholarship_settings_apply_button_title')->nullable();
            $table->string('scholarship_settings_apply_button_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scholarship_settings', function (Blueprint $table) {
            $table->dropColumn('scholarship_settings_apply_button_title');
            $table->dropColumn('scholarship_settings_apply_button_link');
        });
    }
};
