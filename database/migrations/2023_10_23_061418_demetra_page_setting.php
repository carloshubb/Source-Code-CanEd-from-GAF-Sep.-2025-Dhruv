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
        Schema::create('demetra_page_setting', function(Blueprint $table){
            $table->id();
            $table->timestamps();
        });
        Schema::create('demetra_page_setting_detail', function(Blueprint $table){
            $table->id();
            $table->foreignId('demetra_page_setting_id')->nullable()->constrained('demetra_page_setting')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained('languages')->onUpdate('cascade')->onDelete('cascade');
            
            $table->text('demetra_gpa_label', 500)->nullable();
            $table->text('demetra_gpa_placeholder', 500)->nullable();
            $table->text('demetra_gpa_error', 500)->nullable();
            
            $table->text('demetra_sport_label', 500)->nullable();
            $table->text('demetra_sport_placeholder', 500)->nullable();
            $table->text('demetra_sport_error', 500)->nullable();

            $table->text('demetra_comunity_service_label', 500)->nullable();
            $table->text('demetra_comunity_service_placeholder', 500)->nullable();
            $table->text('demetra_comunity_service_error', 500)->nullable();


            $table->text('demetra_financial_help_label', 500)->nullable();
            $table->text('demetra_financial_help_placeholder', 500)->nullable();
            $table->text('demetra_financial_help_error', 500)->nullable();

            $table->text('demetra_acadimic_help_label', 500)->nullable();
            $table->text('demetra_acadimic_help_placeholder', 500)->nullable();
            $table->text('demetra_acadimic_help_error', 500)->nullable();
           
            $table->text('demetra_learning_language_label', 500)->nullable();
            $table->text('demetra_learning_language_placeholder', 500)->nullable();
            $table->text('demetra_learning_language_error', 500)->nullable();
            $table->text('demetra_button_text', 500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demetra_page_setting');
        Schema::dropIfExists('demetra_page_setting_detail');
    }
};
