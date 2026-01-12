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
        Schema::create('school_reverse_search_filters', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('school_id')
                ->nullable()
                ->constrained('schools')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreignId('degree_id')
                ->nullable()
                ->constrained('degrees')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table
                ->foreignId('program_id')
                ->nullable()
                ->constrained('programs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                $table->string('area_of_excellence')->nullable();
                $table->string('area_of_excellence_sub')->nullable();
                $table->string('type_of_help')->nullable();
                $table->string('preferred_location')->nullable();
                $table->string('cgpa')->nullable();
                $table->string('results')->nullable();
                $table->enum('status',[1,0])->default(1);
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
        Schema::dropIfExists('school_reverse_search_filters');
    }
};
