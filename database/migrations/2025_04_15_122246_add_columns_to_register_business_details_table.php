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
        Schema::table('register_business_details', function (Blueprint $table) {
            $table->text('registration_package_heading_text',500)->nullable();
            $table->text('business_profile_heading_text',500)->nullable();
            $table->text('business_category_heading_text',500)->nullable();
            $table->text('media_heading_text',500)->nullable();
            $table->text('social_media_heading_text',500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('register_business_details', function (Blueprint $table) {
            $table->dropColumn('registration_package_heading_text');
            $table->dropColumn('business_profile_heading_text');
            $table->dropColumn('media_heading_text');
            $table->dropColumn('social_media_heading_text');
            $table->dropColumn('business_category_heading_text');
        });
    }
};
