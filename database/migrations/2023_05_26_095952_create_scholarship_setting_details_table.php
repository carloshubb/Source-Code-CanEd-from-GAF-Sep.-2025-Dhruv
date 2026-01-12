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
        Schema::create('scholarship_setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scholarship_setting_id')->nullable()->constrained('scholarship_settings')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('school_scholarship_setting_details');
    }
};
