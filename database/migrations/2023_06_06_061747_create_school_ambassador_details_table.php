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
        Schema::create('school_ambassador_details', function (Blueprint $table) {
            $table->id();
            $table->string('school_ambassador_id')->nullable();
            $table->string('language_code')->nullable();
            $table->text('name');
            $table->longText('about_me');
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
        Schema::dropIfExists('school_ambassador_details');
    }
};
