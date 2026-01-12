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
        Schema::create('register_business_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('register_business_id')->nullable()->constrained('register_businesses')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('page_title',500)->nullable();
            $table->text('package_section_title',500)->nullable();
            $table->text('business_category_1_lable',500)->nullable();
            $table->text('business_category_1_placeholder',500)->nullable();
            $table->text('business_category_1_error',500)->nullable();
            $table->text('business_category_2_lable',500)->nullable();
            $table->text('business_category_2_placeholder',500)->nullable();
            $table->text('business_category_2_error',500)->nullable();
            $table->text('business_category_3_lable',500)->nullable();
            $table->text('business_category_3_placeholder',500)->nullable();
            $table->text('business_category_3_error',500)->nullable();
            $table->text('description_lable',500)->nullable();
            $table->text('description_placeholder',500)->nullable();
            $table->text('description_error',500)->nullable();
            $table->text('contact_lable',500)->nullable();
            $table->text('contact_placeholder',500)->nullable();
            $table->text('contact_error',500)->nullable();

            $table->text('email_lable',500)->nullable();
            $table->text('email_placeholder',500)->nullable();
            $table->text('email_error',500)->nullable();
            $table->text('phone_lable',500)->nullable();
            $table->text('phone_placeholder',500)->nullable();
            $table->text('phone_error',500)->nullable();
            $table->text('address_lable',500)->nullable();
            $table->text('address_placeholder',500)->nullable();
            $table->text('address_error',500)->nullable();

            $table->text('file_lable',500)->nullable();
            $table->text('file_placeholder',500)->nullable();
            $table->text('file_error',500)->nullable();


            $table->text('facebook_lable',500)->nullable();
            $table->text('facebook_placeholder',500)->nullable();
            $table->text('facebook_error',500)->nullable();

            $table->text('twitter_lable',500)->nullable();
            $table->text('twitter_placeholder',500)->nullable();
            $table->text('twitter_error',500)->nullable();

            $table->text('youtube_lable',500)->nullable();
            $table->text('youtube_placeholder',500)->nullable();
            $table->text('youtube_error',500)->nullable();

            $table->text('linkedin_lable',500)->nullable();
            $table->text('linkedin_placeholder',500)->nullable();
            $table->text('linkedin_error',500)->nullable();
            
            $table->text('privacy_text_1',500)->nullable();
            $table->text('privacy_text_2',500)->nullable();
            $table->text('proceed_button_text',500)->nullable();
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
        Schema::dropIfExists('register_business_details');
    }
};
