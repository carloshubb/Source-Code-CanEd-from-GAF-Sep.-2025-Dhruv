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
        Schema::table('school_demetra_settings', function (Blueprint $table) {
            // $table->dropIfExists('cgpa');
            // $table->dropIfExists('financial_help');
            // $table->dropIfExists('acadimic_help');
            // $table->dropIfExists('language_learning');
            // $table->dropForeign(['sport_id']);
            // $table->dropIfExists('sport_id');
            // $table->dropIfExists('social_service');
            // $table->dropIfExists('leader_shipskills');
            // $table->dropIfExists('community_service');
            $table->string('min_cgpa');
            $table->string('max_cgpa');
            $table->enum('conditional_acceptance',['all','yes','no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_demetra_settings', function (Blueprint $table) {
            $table->foreignId('sport_id')->nullable()->constrained('sports')->onUpdate('cascade')->onDelete('cascade');
            $table->string('social_service');
            $table->string('leader_shipskills');
            $table->string('cgpa');
            $table->string('financial_help');
            $table->string('acadimic_help');
            $table->string('language_learning');
            $table->string('community_service');
            // $table->dropIfExists('min_cgpa');
            // $table->dropIfExists('max_cgpa');
            // $table->dropIfExists('conditional_acceptance');
        });
    }
};
