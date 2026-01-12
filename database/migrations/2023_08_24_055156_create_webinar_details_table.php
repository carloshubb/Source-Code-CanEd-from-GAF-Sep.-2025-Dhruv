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
        Schema::create('webinar_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webinar_id')->nullable()->constrained('webinars')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('language_code');
            $table->longText('topic')->nullable();
            $table->longText('agenda')->nullable();
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
        Schema::dropIfExists('webinar_details');
    }
};
