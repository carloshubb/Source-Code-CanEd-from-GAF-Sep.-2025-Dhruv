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
        Schema::create('reg_page_setting', function(Blueprint $table){
            $table->id();
            $table->timestamps();
        });
        Schema::create('reg_page_setting_detail', function(Blueprint $table){
            $table->id();
            $table->foreignId('reg_page_setting_id')->nullable()->constrained('reg_page_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('page_title', 500)->nullable();
            
            $table->text('reg_first_name_label', 500)->nullable();
            $table->text('reg_first_name_placeholder', 500)->nullable();
            $table->text('reg_first_name_error', 500)->nullable();
            
            $table->text('reg_last_name_label', 500)->nullable();
            $table->text('reg_last_name_placeholder', 500)->nullable();
            $table->text('reg_last_name_error', 500)->nullable();

            $table->text('reg_email_label', 500)->nullable();
            $table->text('reg_email_placeholder', 500)->nullable();
            $table->text('reg_email_error', 500)->nullable();


            $table->text('reg_passowrd_label', 500)->nullable();
            $table->text('reg_passowrd_placeholder', 500)->nullable();
            $table->text('reg_passowrd_error', 500)->nullable();

            $table->text('reg_confirm_passowrd_label', 500)->nullable();
            $table->text('reg_confirm_passowrd_placeholder', 500)->nullable();
            $table->text('reg_confirm_passowrd_error', 500)->nullable();

            
            $table->text('privacy_terms_text', 500)->nullable();
            $table->text('reg_button_text', 500)->nullable();

            $table->text('already_register_yet_text', 500)->nullable();
            $table->text('login_button_text', 500)->nullable();
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
        Schema::dropIfExists('reg_page_setting');
        Schema::dropIfExists('reg_page_setting_detail');
    }
};
