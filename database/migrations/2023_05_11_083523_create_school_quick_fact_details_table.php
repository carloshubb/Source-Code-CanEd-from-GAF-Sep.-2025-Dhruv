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
        Schema::create('school_quick_fact_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_quick_fact_id')->nullable()->constrained('school_quick_facts')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('title_1')->nullable();
            $table->longText('title_1_paragraph')->nullable();
            $table->longText('title_2')->nullable();
            $table->longText('title_2_subtitle')->nullable();
            $table->longText('title_2_paragraph')->nullable();
            $table->longText('title_2_button_title')->nullable();
            $table->longText('language_code');
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
        Schema::dropIfExists('school_quick_fact_details');
    }
};
