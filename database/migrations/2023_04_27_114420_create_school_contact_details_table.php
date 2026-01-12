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
        Schema::create('school_contact_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_contact_id')->nullable()->constrained('school_contacts')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('language_code');
            $table->longText('name')->nullable();
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
        Schema::dropIfExists('school_contact_details');
    }
};
