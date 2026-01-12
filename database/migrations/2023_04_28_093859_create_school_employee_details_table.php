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
        Schema::create('school_employee_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_employee_id')->nullable()->constrained('school_employees')->onUpdate('cascade')->onDelete('cascade');
            $table->string('language_code');
            $table->longText('name', 500)->nullable();
            $table->longText('description', 500)->nullable();           
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
        Schema::dropIfExists('school_employee_details');
    }
};
