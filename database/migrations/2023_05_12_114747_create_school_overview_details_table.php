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
        Schema::create('school_overview_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_overview_id')->nullable()->constrained('school_overviews')->onUpdate('cascade')->onDelete('cascade');
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
            $table->longText('title_7_button_title')->nullable();
            $table->longText('title_8')->nullable();
            $table->longText('title_8_paragraph')->nullable();
            $table->longText('title_9')->nullable();
            $table->longText('title_9_subtitle')->nullable();
            $table->longText('title_9_paragraph')->nullable();
            $table->longText('title_9_button_title')->nullable();
            $table->longText('title_9_image_name')->nullable();
            $table->longText('title_10')->nullable();
            $table->longText('title_10_paragraph')->nullable();
            $table->longText('title_11')->nullable();
            $table->longText('title_11_paragraph')->nullable();
            $table->longText('title_12')->nullable();
            $table->longText('title_12_bullet_points')->nullable();
            $table->longText('title_13')->nullable();
            $table->longText('title_13_paragraph')->nullable();
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
        Schema::dropIfExists('school_overview_details');
    }
};
