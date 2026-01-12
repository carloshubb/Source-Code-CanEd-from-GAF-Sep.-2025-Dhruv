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
        Schema::table('school_request_setting_details', function (Blueprint $table) {
            $table->text('image_upload_label', 500)->nullable();
            $table->text('image_upload_placeholder', 500)->nullable();
            $table->text('image_upload_error', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_request_setting_details', function (Blueprint $table) {
            $table->dropIfExists('image_upload_label');
            $table->dropIfExists('image_upload_placeholder');
            $table->dropIfExists('image_upload_error');
        });
    }
};
