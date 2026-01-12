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
        Schema::create('home_page_setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_page_setting_id')->nullable()->constrained('home_page_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('welcome_title',500)->nullable();
            $table->text('welcome_description',500)->nullable();
            $table->text('welcome_button_text',500)->nullable();
            $table->text('welcome_button_link',500)->nullable();
            $table->text('welcome_image',500)->nullable();
            $table->text('featured_title',500)->nullable();
            $table->text('featured_description',500)->nullable();
            $table->text('financial_title',500)->nullable();
            $table->text('financial_description',500)->nullable();
            $table->text('banner_1_title',500)->nullable();
            $table->text('banner_1_description',500)->nullable();
            $table->text('banner_1_button_text',500)->nullable();
            $table->text('banner_1_button_link',500)->nullable();
            $table->text('banner_1_image',500)->nullable();
            $table->text('banner_1_image_2',500)->nullable();
            $table->text('work_while_study_title',500)->nullable();
            $table->text('work_while_study_description',500)->nullable();
            $table->text('banner_2_title',500)->nullable();
            $table->text('banner_2_description',500)->nullable();
            $table->text('banner_2_button_text',500)->nullable();
            $table->text('banner_2_button_link',500)->nullable();
            $table->text('banner_2_image',500)->nullable();
            $table->text('banner_2_image_2',500)->nullable();
            $table->text('proxima_title',500)->nullable();
            $table->text('proxima_description',500)->nullable();
            $table->text('recent_article_title',500)->nullable();
            $table->text('recent_article_description',500)->nullable();
            $table->text('banner_3_title',500)->nullable();
            $table->text('banner_3_description',500)->nullable();
            $table->text('banner_3_button_text',500)->nullable();
            $table->text('banner_3_button_link',500)->nullable();
            $table->text('banner_3_image',500)->nullable();
            $table->text('banner_3_image_2',500)->nullable();
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
        Schema::dropIfExists('home_page_setting_details');
    }
};
