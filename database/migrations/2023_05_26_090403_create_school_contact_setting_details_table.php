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
        Schema::create('school_contact_setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_contact_setting_id')->nullable()->constrained('school_contact_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('main_paragraph')->nullable();
            $table->string('language_code');
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
        Schema::dropIfExists('school_contact_setting_details');
    }
};
