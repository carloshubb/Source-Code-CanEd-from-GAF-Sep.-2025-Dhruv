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
        Schema::create('master_application_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_application_id')->nullable()->constrained('master_applications')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('test_id')->nullable()->constrained('tests')->onUpdate('cascade')->onDelete('cascade');
            $table->string('score')->nullable();
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
        Schema::dropIfExists('master_application_tests');
    }
};
