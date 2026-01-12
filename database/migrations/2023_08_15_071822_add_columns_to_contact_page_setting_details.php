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
        Schema::table('contact_page_setting_details', function (Blueprint $table) {
            $table->text('mainling_address_lable')->nullable();
            $table->text('toll_free_lable')->nullable();
            $table->text('phone_lable')->nullable();
            $table->text('email_lable')->nullable();
            $table->text('website_lable')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_page_setting_details', function (Blueprint $table) {
            $table->dropColumn('mainling_address_lable');
            $table->dropColumn('toll_free_lable');
            $table->dropColumn('phone_lable');
            $table->dropColumn('email_lable');
            $table->dropColumn('website_lable');
        });
    }
};
