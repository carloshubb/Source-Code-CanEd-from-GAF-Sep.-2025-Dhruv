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
            $table->dropColumn('demetra_gpa_label');
            $table->dropColumn('demetra_gpa_placeholder');
            $table->dropColumn('demetra_gpa_error');
            $table->dropColumn('demetra_financial_help_label');
            $table->dropColumn('demetra_financial_help_placeholder');
            $table->dropColumn('demetra_financial_help_error');
            $table->dropColumn('demetra_acadimic_help_label');
            $table->dropColumn('demetra_acadimic_help_placeholder');
            $table->dropColumn('demetra_acadimic_help_error');
            $table->dropColumn('demetra_learning_language_label');
            $table->dropColumn('demetra_learning_language_placeholder');
            $table->dropColumn('demetra_learning_language_error');

            $table->string('min_cgpa_label', 500)->nullable();
            $table->string('min_cgpa_placeholder', 500)->nullable();
            $table->string('min_cgpa_error', 500)->nullable();
            $table->string('max_cgpa_label', 500)->nullable();
            $table->string('max_cgpa_placeholder', 500)->nullable();
            $table->string('max_cgpa_error', 500)->nullable();
            $table->string('conditional_acceptance_label', 500)->nullable();
            $table->string('conditional_acceptance_placeholder', 500)->nullable();
            $table->string('conditional_acceptance_error', 500)->nullable();
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
            $table->string('demetra_gpa_label');
            $table->string('demetra_gpa_placeholder');
            $table->string('demetra_gpa_error');
            $table->string('demetra_financial_help_label');
            $table->string('demetra_financial_help_placeholder');
            $table->string('demetra_financial_help_error');
            $table->string('demetra_acadimic_help_label');
            $table->string('demetra_acadimic_help_placeholder');
            $table->string('demetra_acadimic_help_error');
            $table->string('demetra_learning_language_label');
            $table->string('demetra_learning_language_placeholder');
            $table->string('demetra_learning_language_error');

            $table->dropColumn('min_cgpa_label');
            $table->dropColumn('min_cgpa_placeholder');
            $table->dropColumn('min_cgpa_error');
            $table->dropColumn('max_cgpa_label');
            $table->dropColumn('max_cgpa_placeholder');
            $table->dropColumn('max_cgpa_error');
            $table->dropColumn('conditional_acceptance_label');
            $table->dropColumn('conditional_acceptance_placeholder');
            $table->dropColumn('conditional_acceptance_error');
        });
    }
};
