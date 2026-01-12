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
        Schema::create('master_application_messaging_apps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_application_id')->nullable()->constrained('master_applications')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('messaging_app_id')->nullable()->constrained('messaging_apps')->onUpdate('cascade')->onDelete('cascade');
            $table->string('user_name')->nullable();
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
        Schema::dropIfExists('master_application_messaging_apps');
    }
};
