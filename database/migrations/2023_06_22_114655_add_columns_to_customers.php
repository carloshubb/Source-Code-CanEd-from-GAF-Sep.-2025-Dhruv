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
        Schema::table('customers', function (Blueprint $table) {
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
};
