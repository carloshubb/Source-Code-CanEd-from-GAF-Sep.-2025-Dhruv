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
        Schema::table('home_page_settings', function (Blueprint $table) {
            $table->foreignId('article_section_1_category_id')->nullable()->constrained('article_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('article_section_2_category_id')->nullable()->constrained('article_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('article_section_3_category_id')->nullable()->constrained('article_categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_page_settings', function (Blueprint $table) {
            //
        });
    }
};
