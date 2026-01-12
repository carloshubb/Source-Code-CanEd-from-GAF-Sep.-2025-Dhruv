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
        Schema::create('school_demetra_settings', function (Blueprint $table) {
            $table->id();
            $table->string('cgpa');
            $table->foreignId('sport_id')->nullable()->constrained('sports')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('school_id')->nullable()->constrained('schools')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('community_service');
            $table->boolean('social_service');
            $table->boolean('leader_shipskills');
            $table->boolean('financial_help');
            $table->boolean('acadimic_help');
            $table->boolean('language_learning');
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
        Schema::dropIfExists('school_demetra_settings');
    }
};
