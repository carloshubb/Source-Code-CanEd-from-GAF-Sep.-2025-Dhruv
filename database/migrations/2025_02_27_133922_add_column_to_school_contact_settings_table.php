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
            $table->longText('top_photo')->nullable();
            $table->longText('top_page_text')->nullable();
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
            $table->dropColumn('top_photo');
            $table->dropColumn('top_page_text');
        });
    }
};
