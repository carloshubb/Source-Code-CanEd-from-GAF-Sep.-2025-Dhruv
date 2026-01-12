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
        Schema::table('school_financials', function (Blueprint $table) {
            $table->dropColumn([
                'tab_1_subtitle_1_bps_1_price',
                'tab_1_subtitle_3_bps_1_price',
                'tab_1_subtitle_3_bps_2_price',
                'tab_1_subtitle_3_bps_3_price',
                'tab_2_subtitle_1_bps_1_price',
                'tab_2_subtitle_3_bps_1_price',
                'tab_2_subtitle_3_bps_2_price',
                'tab_2_subtitle_3_bps_3_price',
            ]);
            $table->dropColumn([
                'tab_3_subtitle_1_bps_1_price',
                'tab_3_subtitle_3_bps_1_price',
                'tab_3_subtitle_3_bps_2_price',
                'tab_3_subtitle_3_bps_3_price'
            ]);
            $table->longText('video_url')->nullable();
            $table->longText('video_iframe')->nullable();
        });
        Schema::table('school_financial_details', function (Blueprint $table) {
            $table->dropColumn([
                'title_1',
                'title_1_paragraph',
                'title_2',
                'tab_1_title',
                'tab_1_subtitle_1',
                'tab_1_subtitle_1_bps',
                'tab_1_subtitle_2',
                'tab_1_subtitle_2_paragraph',
                'tab_1_subtitle_3',
                'tab_1_subtitle_3_bps_1',
                'tab_1_subtitle_3_bps_2',
                'tab_1_subtitle_3_bps_3',
                'tab_1_subtitle_3_paragraph',
            ]);
            $table->dropColumn([
                'tab_2_title',
                'tab_2_subtitle_1',
                'tab_2_subtitle_1_bps',
                'tab_2_subtitle_2',
                'tab_2_subtitle_2_paragraph',
                'tab_2_subtitle_3',
                'tab_2_subtitle_3_bps_1',
                'tab_2_subtitle_3_bps_2',
                'tab_2_subtitle_3_bps_3',
                'tab_2_subtitle_3_paragraph',
            ]);
            $table->dropColumn([
                'tab_3_title',
                'tab_3_subtitle_1_bps',
                'tab_3_subtitle_2',
                'tab_3_subtitle_2_paragraph',
                'tab_3_subtitle_3',
                'tab_3_subtitle_3_bps_1',
                'tab_3_subtitle_3_bps_2',
                'tab_3_subtitle_3_bps_3',
                'tab_3_subtitle_3_paragraph',
            ]);
            $table->dropColumn([
                'title_3',
                'title_3_paragraph',
                'title_4',
                'title_4_paragraph',
                'title_5',
                'title_5_paragraph',
                'title_6',
                'title_6_paragraph',
                'title_1_content',
            ]);
            $table->longText('tabs_pre_description')->nullable();
            $table->longText('tabs_post_description')->nullable();
            $table->text('tab1_name', 500)->nullable();
            $table->text('tab2_name', 500)->nullable();
            $table->text('tab3_name', 500)->nullable();
            $table->longText('tab1_description')->nullable();
            $table->longText('tab2_description')->nullable();
            $table->longText('tab3_description')->nullable();
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
        Schema::table('school_financials', function (Blueprint $table) {
            $table->text('tab_1_subtitle_1_bps_1_price')->nullable();
            $table->text('tab_1_subtitle_3_bps_1_price')->nullable();
            $table->text('tab_1_subtitle_3_bps_2_price')->nullable();
            $table->text('tab_1_subtitle_3_bps_3_price')->nullable();
            $table->text('tab_2_subtitle_1_bps_1_price')->nullable();
            $table->text('tab_2_subtitle_3_bps_1_price')->nullable();
            $table->text('tab_2_subtitle_3_bps_2_price')->nullable();
            $table->text('tab_2_subtitle_3_bps_3_price')->nullable();
            $table->text('tab_3_subtitle_1_bps_1_price')->nullable();
            $table->text('tab_3_subtitle_3_bps_1_price')->nullable();
            $table->text('tab_3_subtitle_3_bps_2_price')->nullable();
            $table->text('tab_3_subtitle_3_bps_3_price')->nullable();

            $table->dropColumn('video_url');
            $table->dropColumn('video_iframe');
        });

        Schema::table('school_financial_details', function (Blueprint $table) {
            $table->longText('title_1')->nullable();
            $table->longText('title_1_paragraph')->nullable();
            $table->longText('title_2')->nullable();
            $table->longText('tab_1_title')->nullable();
            $table->longText('tab_1_subtitle_1')->nullable();
            $table->longText('tab_1_subtitle_1_bps')->nullable();
            $table->longText('tab_1_subtitle_2')->nullable();
            $table->longText('tab_1_subtitle_2_paragraph')->nullable();
            $table->longText('tab_1_subtitle_3')->nullable();
            $table->longText('tab_1_subtitle_3_bps_1')->nullable();
            $table->longText('tab_1_subtitle_3_bps_2')->nullable();
            $table->longText('tab_1_subtitle_3_bps_3')->nullable();
            $table->longText('tab_1_subtitle_3_paragraph')->nullable();
            $table->longText('tab_2_title')->nullable();
            $table->longText('tab_2_subtitle_1')->nullable();
            $table->longText('tab_2_subtitle_1_bps')->nullable();
            $table->longText('tab_2_subtitle_2')->nullable();
            $table->longText('tab_2_subtitle_2_paragraph')->nullable();
            $table->longText('tab_2_subtitle_3')->nullable();
            $table->longText('tab_2_subtitle_3_bps_1')->nullable();
            $table->longText('tab_2_subtitle_3_bps_2')->nullable();
            $table->longText('tab_2_subtitle_3_bps_3')->nullable();
            $table->longText('tab_2_subtitle_3_paragraph')->nullable();
            $table->longText('tab_3_title')->nullable();
            $table->longText('tab_3_subtitle_1_bps')->nullable();
            $table->longText('tab_3_subtitle_2')->nullable();
            $table->longText('tab_3_subtitle_2_paragraph')->nullable();
            $table->longText('tab_3_subtitle_3')->nullable();
            $table->longText('tab_3_subtitle_3_bps_1')->nullable();
            $table->longText('tab_3_subtitle_3_bps_2')->nullable();
            $table->longText('tab_3_subtitle_3_bps_3')->nullable();
            $table->longText('tab_3_subtitle_3_paragraph')->nullable();
            $table->longText('title_3')->nullable();
            $table->longText('title_3_paragraph')->nullable();
            $table->longText('title_4')->nullable();
            $table->longText('title_4_paragraph')->nullable();
            $table->longText('title_5')->nullable();
            $table->longText('title_5_paragraph')->nullable();
            $table->longText('title_6')->nullable();
            $table->longText('title_6_paragraph')->nullable();
            $table->longText('title_1_content')->nullable();

            $table->dropColumn('tabs_pre_description');
            $table->dropColumn('tabs_post_description');
            $table->dropColumn('tab1_name');
            $table->dropColumn('tab2_name');
            $table->dropColumn('tab3_name');
            $table->dropColumn('tab1_description');
            $table->dropColumn('tab2_description');
            $table->dropColumn('tab3_description');
            $table->dropColumn('scholarship_pre_description');
            $table->dropColumn('scholarship_post_description');
            $table->dropColumn('programs_pre_description');
            $table->dropColumn('programs_post_description');
            $table->dropColumn('faq_pre_description');
            $table->dropColumn('faq_post_description');
        });
    }
};
