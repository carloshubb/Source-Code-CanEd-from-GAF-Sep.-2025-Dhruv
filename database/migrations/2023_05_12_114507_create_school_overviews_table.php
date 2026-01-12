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
        Schema::create('school_overviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->text('title_3_image')->nullable();
            $table->text('title_3_date')->nullable();
            $table->text('title_4_image')->nullable();
            $table->text('title_3_button_link')->nullable();
            $table->text('title_6_button_link')->nullable();
            $table->text('title_8_button_link')->nullable();
            $table->text('title_9_image')->nullable();
            $table->text('title_9_button_link')->nullable();
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
        Schema::dropIfExists('school_overviews');
    }
};
