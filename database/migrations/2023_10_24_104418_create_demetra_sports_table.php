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
        Schema::create('demetra_sports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_demetra_setting_id')->nullable()->constrained('school_demetra_settings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('sport_id')->nullable()->constrained('sports')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('demetra_sports');
    }
};
