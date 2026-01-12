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
        Schema::table('register_business_details', function (Blueprint $table) {
            $table->text('name_lable',500)->nullable();
            $table->text('name_placeholder',500)->nullable();
            $table->text('name_error',500)->nullable();
            $table->text('website_url_lable',500)->nullable();
            $table->text('website_url_placeholder',500)->nullable();
            $table->text('website_url_error',500)->nullable();
            $table->text('social_media_title',500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('register_business_details', function (Blueprint $table) {
            //
        });
    }
};
