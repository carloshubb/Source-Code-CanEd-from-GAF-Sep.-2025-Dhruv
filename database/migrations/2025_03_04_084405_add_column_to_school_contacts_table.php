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
        Schema::table('school_contacts', function (Blueprint $table) {
            $table->longText('contact_facebook')->nullable();
            $table->longText('contact_instagram')->nullable();
            $table->longText('contact_linkedin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_contacts', function (Blueprint $table) {
            $table->dropColumn('contact_facebook');
            $table->dropColumn('contact_instagram');
            $table->dropColumn('contact_linkedin');
        });
    }
};
