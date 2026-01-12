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
        Schema::table('scholarship_settings', function (Blueprint $table) {
            $table->dropColumn([
                'title_2_button_link',
                'title_2_image',
                'title_4_button_link',
                'title_4_image',
            ]);
            
            $table->text('video_url', 1000)->nullable();
            $table->longText('video_iframe')->nullable();
        });
        Schema::table('scholarship_setting_details', function (Blueprint $table) {
            $table->dropColumn([
                'title_1',
                'title_1_paragraph',
                'text_1_content',
                'text_2_content',
                'title_2',
                'title_2_subtitle',
                'title_2_paragraph',
                'title_2_button_title',
                'title_2_image_name',
                'title_3',
                'title_3_paragraph',
                'text_3_content',
                'title_4',
                'title_4_subtitle',
                'title_4_paragraph',
                'title_4_button_title',
                'title_4_image_name',
            ]);
            $table->longText('scholarship_pre_description')->nullable();
            $table->longText('scholarship_post_description')->nullable();
            $table->longText('programs_pre_description')->nullable();
            $table->longText('programs_post_description')->nullable();
            $table->longText('faq_pre_description')->nullable();
            $table->longText('faq_post_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scholarship_settings', function (Blueprint $table) {
            $table->text('title_2_button_link')->nullable();
            $table->text('title_2_image')->nullable();
            $table->text('title_4_button_link')->nullable();
            $table->text('title_4_image')->nullable();
            $table->dropColumn('video_url');
            $table->dropColumn('video_iframe');
        });
        Schema::table('scholarship_setting_details', function (Blueprint $table) {
            $table->text('title_1')->nullable();
            $table->text('title_1_paragraph')->nullable();
            $table->text('text_1_content')->nullable();
            $table->text('text_2_content')->nullable();
            $table->text('title_2')->nullable();
            $table->text('title_2_subtitle')->nullable();
            $table->text('title_2_paragraph')->nullable();
            $table->text('title_2_button_title')->nullable();
            $table->text('title_2_image_name')->nullable();
            $table->text('title_3')->nullable();
            $table->text('title_3_paragraph')->nullable();
            $table->text('text_3_content')->nullable();
            $table->text('title_4')->nullable();
            $table->text('title_4_subtitle')->nullable();
            $table->text('title_4_paragraph')->nullable();
            $table->text('title_4_button_title')->nullable();
            $table->text('title_4_image_name')->nullable();
        });
    }
};
