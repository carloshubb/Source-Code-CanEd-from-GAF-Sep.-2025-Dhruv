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
        Schema::create('open_day_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('open_day_id')->nullable()->constrained('open_days')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('language_code');
            $table->longText('title')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('open_day_details');
    }
};
