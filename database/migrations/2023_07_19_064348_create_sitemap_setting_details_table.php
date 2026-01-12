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
        Schema::create('sitemap_setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sitemap_setting_id')->nullable()->constrained('sitemap_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('section_1_title')->nullable();
            $table->text('section_2_title')->nullable();
            $table->text('section_3_title')->nullable();
            $table->text('section_4_title')->nullable();
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
        Schema::dropIfExists('sitemap_setting_details');
    }
};
