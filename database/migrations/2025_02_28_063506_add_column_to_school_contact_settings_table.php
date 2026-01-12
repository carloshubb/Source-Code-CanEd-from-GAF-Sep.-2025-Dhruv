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
        Schema::table('school_contact_settings', function (Blueprint $table) {
            $table->longText('contact_settings_facebook')->nullable();
            $table->longText('contact_settings_instagram')->nullable();
            $table->longText('contact_settings_linkedin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_contact_settings', function (Blueprint $table) {
            $table->dropColumn('contact_settings_facebook');
            $table->dropColumn('contact_settings_instagram');
            $table->dropColumn('contact_settings_linkedin');
        });
    }
};
