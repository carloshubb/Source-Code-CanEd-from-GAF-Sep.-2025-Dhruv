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
        Schema::create('school_program_degree_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_program_id')->nullable()->constrained('school_programs')->onUpdate('set null')->onDelete('set null');
            $table->foreignId('degree_id')->nullable()->constrained('degrees')->onUpdate('set null')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_program_degree_levels');
    }
};
