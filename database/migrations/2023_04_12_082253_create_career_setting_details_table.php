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
        Schema::create('career_setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_setting_id')->nullable()->constrained('career_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('page_title')->nullable();
            $table->text('tab_1_title')->nullable();
            $table->text('tab_2_title')->nullable();
            $table->text('tab_3_title')->nullable();
            $table->text('search_input_placeholder')->nullable();
            $table->text('article_title')->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('caree_setting_details');
    }
};
