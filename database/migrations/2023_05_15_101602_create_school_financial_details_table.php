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
        Schema::create('school_financial_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_financial_id')->nullable()->constrained('school_financials')->onUpdate('cascade')->onDelete('cascade');
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
            $table->longText('tab_3_subtitle_1')->nullable();
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
            $table->string('language_code')->nullable();
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
        Schema::dropIfExists('school_financial_details');
    }
};
