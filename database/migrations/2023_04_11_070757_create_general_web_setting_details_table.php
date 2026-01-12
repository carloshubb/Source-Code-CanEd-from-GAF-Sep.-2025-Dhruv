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
        Schema::create('general_web_setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_web_setting_id')->nullable()->constrained('login_page_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('page_title', 500)->nullable();
            $table->text('login_email_label', 500)->nullable();
            $table->text('login_email_placeholder', 500)->nullable();
            $table->text('login_email_error', 500)->nullable();
            $table->text('login_passowrd_label', 500)->nullable();
            $table->text('login_passowrd_placeholder', 500)->nullable();
            $table->text('login_passowrd_error', 500)->nullable();
            $table->text('keep_me_logged_in_text', 500)->nullable();
            $table->longText('forget_password_text')->nullable();
            $table->text('login_button_text', 500)->nullable();
            $table->text('not_register_yet_text', 500)->nullable();
            $table->text('create_account_button_text', 500)->nullable();
            $table->text('protect_your_account_text', 500)->nullable();
            $table->text('protect_your_account_description', 500)->nullable();
            $table->text('register_a_school_text', 500)->nullable();
            $table->text('register_a_school_link', 500)->nullable();
            $table->text('register_a_business_text', 500)->nullable();
            $table->text('register_a_business_link', 500)->nullable();
            $table->text('login_text', 500)->nullable();
            $table->text('login_link', 500)->nullable();
            $table->text('schools_text', 500)->nullable();
            $table->text('schools_link', 500)->nullable();
            $table->text('scholarship_ext', 500)->nullable();
            $table->text('scholarship_link', 500)->nullable();
            $table->text('business_ext', 500)->nullable();
            $table->text('business_link', 500)->nullable();
            $table->text('careers_ext', 500)->nullable();
            $table->text('careers_link', 500)->nullable();
            $table->text('jobs_text', 500)->nullable();
            $table->text('jobs_link', 500)->nullable();
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
        Schema::dropIfExists('general_web_setting_details');
    }
};
