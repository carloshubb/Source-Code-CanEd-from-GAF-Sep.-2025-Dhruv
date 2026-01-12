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
            $table->text('welcome_video_label')->nullable();
            $table->text('welcome_video_placeholder')->nullable();
            $table->text('welcome_video_error')->nullable();
            $table->text('keywords_label')->nullable();
            $table->text('keywords_placeholder')->nullable();
            $table->text('keywords_error')->nullable();
            $table->text('password_label')->nullable();
            $table->text('password_placeholder')->nullable();
            $table->text('password_error')->nullable();
            $table->text('confirm_password_label')->nullable();
            $table->text('confirm_password_placeholder')->nullable();
            $table->text('confirm_password_error')->nullable();
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
            $table->dropColumn(['welcome_video_error', 'welcome_video_placeholder', 'welcome_video_label',
                'keywords_error', 'keywords_placeholder', 'keywords_label', 'password_error', 'password_placeholder',
                'password_label', 'confirm_password_error', 'confirm_password_placeholder', 'confirm_password_label'
            ]);
        });
    }
};
