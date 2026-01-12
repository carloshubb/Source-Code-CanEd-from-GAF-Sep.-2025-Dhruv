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
        Schema::create('school_request_setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_request_setting_id')->nullable()->constrained('school_request_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('page_title', 500)->nullable();
            $table->text('name_label', 500)->nullable();
            $table->text('name_placeholder', 500)->nullable();
            $table->text('name_error', 500)->nullable();
            $table->text('website_label', 500)->nullable();
            $table->text('website_placeholder', 500)->nullable();
            $table->text('website_error', 500)->nullable();
            $table->text('email_label', 500)->nullable();
            $table->text('email_placeholder', 500)->nullable();
            $table->text('email_error', 500)->nullable();
            $table->text('phone_label', 500)->nullable();
            $table->text('phone_placeholder', 500)->nullable();
            $table->text('phone_error', 500)->nullable();
            $table->text('time_label', 500)->nullable();
            $table->text('time_placeholder', 500)->nullable();
            $table->text('time_error', 500)->nullable();
            $table->text('time_zone_label', 500)->nullable();
            $table->text('time_zone_placeholder', 500)->nullable();
            $table->text('time_zone_error', 500)->nullable();
            $table->text('province_label', 500)->nullable();
            $table->text('province_placeholder', 500)->nullable();
            $table->text('province_error', 500)->nullable();
            $table->text('country_label', 500)->nullable();
            $table->text('country_placeholder', 500)->nullable();
            $table->text('country_error', 500)->nullable();
            $table->text('description', 500)->nullable();
            $table->text('protect_your_account_text', 500)->nullable();
            $table->text('protect_your_account_description', 500)->nullable();
            $table->string('submit_button_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_request_setting_details');
    }
};
