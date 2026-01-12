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
        Schema::table('demetra_page_setting_detail', function (Blueprint $table) {
            $table->string('demetra_curricular_label', 500)->nullable();
            $table->string('demetra_entrepreneurship_label', 500)->nullable();
            $table->string('demetra_environmental_label', 500)->nullable();
            $table->string('demetra_extracurricular_label', 500)->nullable();
            $table->string('demetra_health_wellness_label', 500)->nullable();
            $table->string('demetra_leadership_label', 500)->nullable();
            $table->string('demetra_media_label', 500)->nullable();
            $table->string('demetra_music_performance_label', 500)->nullable();
            $table->string('demetra_social_activism_label', 500)->nullable();
            $table->string('demetra_stem_competitions_label', 500)->nullable();
            $table->string('demetra_technology_label', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demetra_page_setting_detail', function (Blueprint $table) {
            $table->dropColumn('demetra_curricular_label');
            $table->dropColumn('demetra_entrepreneurship_label');
            $table->dropColumn('demetra_environmental_label');
            $table->dropColumn('demetra_extracurricular_label');
            $table->dropColumn('demetra_health_wellness_label');
            $table->dropColumn('demetra_leadership_label');
            $table->dropColumn('demetra_media_label');
            $table->dropColumn('demetra_music_performance_label');
            $table->dropColumn('demetra_social_activism_label');
            $table->dropColumn('demetra_stem_competitions_label');
            $table->dropColumn('demetra_technology_label');
        });
    }
};
