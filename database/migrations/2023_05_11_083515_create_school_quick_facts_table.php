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
        Schema::create('school_quick_facts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('title_2_image')->nullable();
            $table->longText('title_2_button_link')->nullable();
            $table->longText('school_location')->nullable();
            $table->longText('school_type')->nullable();
            $table->longText('languages')->nullable();
            $table->longText('total_undergraduates')->nullable();
            $table->longText('entrance_dates')->nullable();
            $table->longText('canidian_tuition_fee')->nullable();
            $table->longText('international_tuition_fee')->nullable();
            $table->longText('telephone')->nullable();
            $table->longText('fax')->nullable();
            $table->longText('school_address')->nullable();
            $table->longText('start_date')->nullable();
            $table->longText('online_or_distance_education')->nullable();
            $table->longText('minimum_gpa')->nullable();
            $table->longText('conditional_admission')->nullable();
            $table->longText('number_of_graduate_programs')->nullable();
            $table->longText('number_of_undergraduate_programs')->nullable();
            $table->longText('number_of_students')->nullable();
            $table->longText('number_of_graduate_students')->nullable();
            $table->longText('number_of_undergraduate_students')->nullable();
            $table->longText('study_method')->nullable();
            $table->longText('delivery_mode')->nullable();
            $table->longText('accomodation')->nullable();
            $table->longText('work_on_campus')->nullable();
            $table->longText('work_during_holidays')->nullable();
            $table->longText('internship')->nullable();
            $table->longText('co_op_education')->nullable();
            $table->longText('job_placement')->nullable();
            $table->longText('financial_aid_programs_for_domastic_students')->nullable();
            $table->longText('financial_aid_programs_for_international_students')->nullable();
            $table->longText('research_and_dissertaion')->nullable();
            $table->longText('exchange_program')->nullable();
            $table->longText('degree_modifier')->nullable();
            $table->longText('daycare_for_students_with_kids')->nullable();
            $table->longText('elementary_school_for_students_with_kids')->nullable();
            $table->longText('immigration_office_on_campus')->nullable();
            $table->longText('career_planing')->nullable();
            $table->longText('pathway_programs')->nullable();
            $table->longText('employeement_rates')->nullable();
            $table->longText('class_size_undergraduate')->nullable();
            $table->longText('class_size_masters')->nullable();
            $table->longText('service_and_guidance_new_students')->nullable();
            $table->longText('service_and_guidance_to_new_arrivals_in_canada')->nullable();
            $table->text('marked_facts')->nullable();
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
        Schema::dropIfExists('school_quick_facts');
    }
};
