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
        Schema::create('school_ambassadors', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('region');
            $table->text('langs');
            $table->text('currently_in');
            $table->text('fav_module');
            $table->text('hobies_interests');
            $table->text('societies');
            $table
            ->foreignId('school_id')
            ->nullable()
            ->constrained('schools')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->timestamps();
            $table
            ->foreignId('customer_id')
            ->nullable()
            ->constrained('customers')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_ambassadors');
    }
};
