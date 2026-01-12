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
        Schema::table('school_overviews', function (Blueprint $table) {
            $table->dropColumn('title_3_image');
            $table->dropColumn('title_3_date');
            $table->dropColumn('title_4_image');
            $table->dropColumn('title_3_button_link');
            $table->dropColumn('title_6_button_link');
            $table->dropColumn('title_8_button_link');
            $table->dropColumn('title_9_image');
            $table->dropColumn('title_9_button_link');
        });
        Schema::table('school_overview_details', function (Blueprint $table) {
            $table->dropColumn('title_1');
            $table->dropColumn('title_1_paragraph');
            $table->dropColumn('title_1_content');
            $table->dropColumn('title_2');
            $table->dropColumn('title_2_bullet_points');
            $table->dropColumn('title_3_subtitle');
            $table->dropColumn('title_3_paragraph');
            $table->dropColumn('title_3_button_title');
            $table->dropColumn('title_3_image_name');
            $table->dropColumn('title_4');
            $table->dropColumn('title_4_paragraph');
            $table->dropColumn('title_5');
            $table->dropColumn('title_5_paragraph');
            $table->dropColumn('title_6');
            $table->dropColumn('title_6_paragraph');
            $table->dropColumn('title_6_button_title');
            $table->dropColumn('title_7');
            $table->dropColumn('title_7_paragraph');
            $table->dropColumn('title_8');
            $table->dropColumn('title_8_paragraph');
            $table->dropColumn('title_7_button_title');
            $table->dropColumn('title_9');
            $table->dropColumn('title_9_subtitle');
            $table->dropColumn('title_9_paragraph');
            $table->dropColumn('title_9_button_title');
            $table->dropColumn('title_9_image_name');
            $table->dropColumn('title_10');
            $table->dropColumn('title_10_paragraph');
            $table->dropColumn('title_11');
            $table->dropColumn('title_11_paragraph');
            $table->dropColumn('title_12');
            $table->dropColumn('title_12_bullet_points');
            $table->dropColumn('title_13');
            $table->dropColumn('title_13_paragraph');
        });
        Schema::table('school_overviews', function (Blueprint $table) {
            $table->boolean('display_blog')->default(0);
            $table->integer('number_of_blog_posts')->default(0);
            $table->enum('blog_posts_order', ['random', 'latest'])->nullable();
            $table->text('video_url', 1000)->nullable();
            $table->longText('video_iframe')->nullable();
        });
        Schema::table('school_overview_details', function (Blueprint $table) {
            $table->longText('blog_pre_description')->nullable();
            $table->longText('blog_post_description')->nullable();
            $table->longText('programs_pre_description')->nullable();
            $table->longText('programs_post_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_overviews', function (Blueprint $table) {
            $table->text('title_3_image')->nullable();
            $table->text('title_3_date')->nullable();
            $table->text('title_4_image')->nullable();
            $table->text('title_3_button_link')->nullable();
            $table->text('title_6_button_link')->nullable();
            $table->text('title_8_button_link')->nullable();
            $table->text('title_9_image')->nullable();
            $table->text('title_9_button_link')->nullable();
        });
        Schema::table('school_overview_details', function (Blueprint $table) {
            $table->longText('title_1')->nullable();
            $table->longText('title_1_paragraph')->nullable();
            $table->longText('title_1_content')->nullable();
            $table->longText('title_2')->nullable();
            $table->longText('title_2_bullet_points')->nullable();
            $table->longText('title_3_subtitle')->nullable();
            $table->longText('title_3_paragraph')->nullable();
            $table->longText('title_3_button_title')->nullable();
            $table->longText('title_3_image_name')->nullable();
            $table->longText('title_4')->nullable();
            $table->longText('title_4_paragraph')->nullable();
            $table->longText('title_5')->nullable();
            $table->longText('title_5_paragraph')->nullable();
            $table->longText('title_6')->nullable();
            $table->longText('title_6_paragraph')->nullable();
            $table->longText('title_6_button_title')->nullable();
            $table->longText('title_7')->nullable();
            $table->longText('title_7_paragraph')->nullable();
            $table->longText('title_8')->nullable();
            $table->longText('title_8_paragraph')->nullable();
            $table->text('title_7_button_title')->nullable();
            $table->longText('title_9')->nullable();
            $table->longText('title_9_subtitle')->nullable();
            $table->longText('title_9_paragraph')->nullable();
            $table->text('title_9_button_title')->nullable();
            $table->longText('title_9_image_name')->nullable();
            $table->longText('title_10')->nullable();
            $table->longText('title_10_paragraph')->nullable();
            $table->longText('title_11')->nullable();
            $table->longText('title_11_paragraph')->nullable();
            $table->longText('title_12')->nullable();
            $table->longText('title_12_bullet_points')->nullable();
            $table->longText('title_13')->nullable();
            $table->longText('title_13_paragraph')->nullable();
        });
        Schema::table('school_overviews', function (Blueprint $table) {
            $table->dropColumn('display_blog');
            $table->dropColumn('number_of_blog_posts');
            $table->dropColumn('blog_posts_order');
        });
        Schema::table('school_overview_details', function (Blueprint $table) {
            $table->dropColumn('blog_pre_description');
            $table->dropColumn('blog_post_description');
            $table->dropColumn('programs_pre_description');
            $table->dropColumn('programs_post_description');
        });
    }
};
