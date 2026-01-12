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
        Schema::table('admission_setting_details', function (Blueprint $table) {
            $table->dropColumn([
                'main_paragraph',
                'title_1',
                'title_1_paragraph',
                'text_1_content',
                'title_2',
                'title_2_bullet_points',
                'title_3',
                'title_3_paragraph',
                'title_4',
                'title_4_paragraph',
                'title_5',
                'title_5_paragraph',
            ]);
            
            $table->longText('employees_pre_description')->nullable();
            $table->longText('employees_post_description')->nullable();
            $table->longText('team_pre_description')->nullable();
            $table->longText('team_post_description')->nullable();
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
        Schema::table('admission_setting_details', function (Blueprint $table) {
            $table->longText('main_paragraph', 500)->nullable();
            $table->longText('title_1', 500)->nullable();
            $table->longText('title_1_paragraph', 500)->nullable();
            $table->longText('text_1_content', 500)->nullable();
            $table->longText('title_2', 500)->nullable();
            $table->longText('title_2_bullet_points', 500)->nullable();
            $table->longText('title_3', 500)->nullable();
            $table->longText('title_3_paragraph', 500)->nullable();
            $table->longText('title_4', 500)->nullable();
            $table->longText('title_4_paragraph', 500)->nullable();
            $table->longText('title_5', 500)->nullable();
            $table->longText('title_5_paragraph', 500)->nullable();
        });
    }
};
