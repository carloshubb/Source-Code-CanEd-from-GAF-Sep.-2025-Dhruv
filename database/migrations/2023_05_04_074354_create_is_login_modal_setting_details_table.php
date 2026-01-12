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
        Schema::create('is_login_modal_setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('is_login_modal_setting_id')->nullable()->constrained('is_login_modal_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            $table->text('modal_title', 500)->nullable();
            $table->text('login_button_text', 500)->nullable();
            $table->text('register_button_text', 500)->nullable();
            $table->text('back_button_text', 500)->nullable();
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
        Schema::dropIfExists('is_login_modal_setting_details');
    }
};
