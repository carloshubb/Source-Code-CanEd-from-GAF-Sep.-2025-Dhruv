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
        Schema::create('admission_setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_setting_id')->nullable()->constrained('admission_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->string('language_code');
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
        Schema::dropIfExists('admission_setting_details');
    }
};
