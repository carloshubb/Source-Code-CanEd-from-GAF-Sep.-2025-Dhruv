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
            $table->dropColumn('banner_1_title')->nullable();
            $table->dropColumn('banner_1_description')->nullable();
            $table->dropColumn('banner_1_button_text')->nullable();
            $table->dropColumn('banner_1_button_link')->nullable();
            $table->dropColumn('banner_1_image')->nullable();
            $table->dropColumn('banner_1_image_2')->nullable();
            
            $table->dropColumn('banner_2_title')->nullable();
            $table->dropColumn('banner_2_description')->nullable();
            $table->dropColumn('banner_2_button_text')->nullable();
            $table->dropColumn('banner_2_button_link')->nullable();
            $table->dropColumn('banner_2_image')->nullable();
            $table->dropColumn('banner_2_image_2')->nullable();


            $table->dropColumn('banner_3_title')->nullable();
            $table->dropColumn('banner_3_description')->nullable();
            $table->dropColumn('banner_3_button_text')->nullable();
            $table->dropColumn('banner_3_button_link')->nullable();
            $table->dropColumn('banner_3_image')->nullable();
            $table->dropColumn('banner_3_image_2')->nullable();
        });


        Schema::table('home_page_settings', function (Blueprint $table) {
            $table->foreignId('banner_1')->nullable()->constrained('banners')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('banner_2')->nullable()->constrained('banners')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('banner_3')->nullable()->constrained('banners')->onUpdate('cascade')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
