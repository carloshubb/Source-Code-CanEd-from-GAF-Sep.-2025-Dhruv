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
        Schema::table('school_ambassadors', function (Blueprint $table) {
            $table->string('zoho_client_id')->nullable();
            $table->string('zoho_client_secret')->nullable();
            $table->string('zoho_refresh_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_ambassadors', function (Blueprint $table) {
            $table->dropColumn('zoho_client_id');
            $table->dropColumn('zoho_client_secret');
            $table->dropColumn('zoho_refresh_token');
        });
    }
};
