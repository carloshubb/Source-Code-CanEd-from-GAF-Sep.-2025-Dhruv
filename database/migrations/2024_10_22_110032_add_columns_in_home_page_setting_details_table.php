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
        Schema::table('home_page_setting_details', function (Blueprint $table) {
            $table->text('article_card_title',500)->after('recent_article_description')->nullable();
            $table->text('video_card_title',500)->after('article_card_title')->nullable();
            $table->text('recent_article_image',500)->after('video_card_title')->nullable();
            $table->text('recent_video_image',500)->after('recent_article_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_page_setting_details', function (Blueprint $table) {
            $table->dropColumn(['recent_video_image', 'recent_article_image', 'video_card_title', 'article_card_title']);
        });
    }
};
