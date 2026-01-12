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
        Schema::create('contact_page_setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_page_setting_id')->nullable()->constrained('contact_page_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('page_title_1')->nullable();
            $table->text('page_title_2')->nullable();
            $table->text('description')->nullable();
            $table->text('mainling_address')->nullable();
            $table->text('toll_free')->nullable();
            $table->text('phone')->nullable();
            $table->text('email')->nullable();
            $table->text('website')->nullable();
            $table->text('name_input_lable')->nullable();
            $table->text('name_input_placeholder')->nullable();
            $table->text('name_input_error')->nullable();
            $table->text('email_input_lable')->nullable();
            $table->text('email_input_placeholder')->nullable();
            $table->text('email_input_error')->nullable();
            $table->text('message_input_lable')->nullable();
            $table->text('message_input_placeholder')->nullable();
            $table->text('message_input_error')->nullable();
            $table->text('button_text')->nullable();
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
        Schema::dropIfExists('contact_page_setting_details');
    }
};
