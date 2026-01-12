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
        Schema::table('login_page_detail_settings', function (Blueprint $table) {
            $table->longText('facebook_login_text')->nullable();
            $table->longText('google_login_text')->nullable();
            $table->longText('linkedin_login_text')->nullable();
            $table->longText('email_format_error_text')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('login_page_detail_settings', function (Blueprint $table) {
            $table->dropColumn('facebook_login_text');
            $table->dropColumn('google_login_text');
            $table->dropColumn('linkedin_login_text');
            $table->dropColumn('email_format_error_text');
        });
    }
};
