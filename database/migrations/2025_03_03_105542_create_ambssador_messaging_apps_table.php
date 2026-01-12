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
        Schema::create('ambssador_messaging_apps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('messaging_app_id')->nullable()->constrained('messaging_apps')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('ambassadors_id')->nullable()->constrained('school_ambassadors')->onUpdate('cascade')->onDelete('cascade');
            $table->string('username')->nullable();
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
        Schema::dropIfExists('ambssador_messaging_apps');
    }
};
