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
        Schema::create('login_page_detail_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('login_page_setting_id')->nullable()->constrained('login_page_settings')->onUpdate('cascade')->onDelete('cascade');
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('login_page_detail_settings');
    }
};
