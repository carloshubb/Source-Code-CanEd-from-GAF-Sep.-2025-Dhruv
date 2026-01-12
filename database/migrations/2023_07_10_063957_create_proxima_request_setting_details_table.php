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
        Schema::create('proxima_request_setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prox_req_set_id')->nullable()->constrained('proxima_request_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('call_to_action_text', 500)->nullable();
            $table->text('name_label', 500)->nullable();
            $table->text('name_placeholder', 500)->nullable();
            $table->text('name_error', 500)->nullable();
            $table->text('phone_label', 500)->nullable();
            $table->text('phone_placeholder', 500)->nullable();
            $table->text('phone_error', 500)->nullable();
            $table->text('email_label', 500)->nullable();
            $table->text('email_placeholder', 500)->nullable();
            $table->text('email_error', 500)->nullable();
            $table->text('inquiry_label', 500)->nullable();
            $table->text('inquiry_placeholder', 500)->nullable();
            $table->text('inquiry_error', 500)->nullable();
            $table->text('button_text', 500)->nullable();
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
        Schema::dropIfExists('proxima_request_setting_details');
    }
};
