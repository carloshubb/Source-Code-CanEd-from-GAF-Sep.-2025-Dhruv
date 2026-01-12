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
        Schema::create('school_quick_facts_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_quick_fact_id')->nullable()->constrained('school_quick_facts')->onUpdate('cascade')->onDelete('cascade');
            $table->text('value', 1000)->nullable();
            $table->enum('type', ['school_location', 'school_type', 'languages', 'total_undergraduates', 'entrance_dates', 'canidian_tuition_fee', 'international_tuition_fee', 'telephone', 'fax', 'school_address', 'start_date', 'online_or_distance_education', 'minimum_gpa', 'conditional_admission', 'number_of_graduate_programs', 'number_of_undergraduate_programs', 'number_of_students', 'number_of_graduate_students', 'number_of_undergraduate_students', 'study_method', 'delivery_mode', 'accomodation', 'work_on_campus', 'work_during_holidays', 'internship', 'co_op_education', 'job_placement', 'financial_aid_programs_for_domastic_students', 'financial_aid_programs_for_province_students', 'financial_aid_programs_for_international_students', 'research_and_dissertaion', 'exchange_program', 'degree_modifier', 'daycare_for_students_with_kids', 'elementary_school_for_students_with_kids', 'immigration_office_on_campus', 'career_planing', 'pathway_programs', 'employeement_rates', 'class_size_undergraduate', 'class_size_masters', 'service_and_guidance_new_students', 'service_and_guidance_to_new_arrivals_in_canada', 'work_off_campus', 'years_before_elegible_for_pr', 'program_type_greduates', 'program_type_undergreduates', 'field_of_study'])->nullable();
            $table->boolean('is_featured')->default(0);
            $table->string('sorting_order')->nullable();
            $table->timestamps();
        });

        // Schema::table('school_quick_facts', function (Blueprint $table) {
        //     $table->dropColumn([
        //         'school_location',
        //         'school_type',
        //         'languages',
        //         'total_undergraduates',
        //         'entrance_dates',
        //         'canidian_tuition_fee',
        //         'international_tuition_fee',
        //     ]);
        //     $table->dropColumn([
        //         'telephone',
        //         'fax',
        //         'school_address',
        //         'start_date',
        //         'online_or_distance_education',
        //         'minimum_gpa',
        //         'conditional_admission',
        //     ]);
        //     $table->dropColumn([
        //         'number_of_graduate_programs',
        //         'number_of_undergraduate_programs',
        //         'number_of_students',
        //         'number_of_graduate_students',
        //         'number_of_undergraduate_students',
        //         'study_method',
        //         'delivery_mode',
        //     ]);
        //     $table->dropColumn([
        //         'accomodation',
        //         'work_on_campus',
        //         'work_during_holidays',
        //         'internship',                                               
        //         'co_op_education',
        //         'job_placement',
        //         'financial_aid_programs_for_domastic_students',
        //     ]);
        //     $table->dropColumn([
        //         'financial_aid_programs_for_province_students',
        //         'financial_aid_programs_for_international_students',
        //         'research_and_dissertaion',
        //         'exchange_program',
        //         'degree_modifier',
        //         'daycare_for_students_with_kids',
        //         'elementary_school_for_students_with_kids',
        //         'immigration_office_on_campus',
        //     ]);
        //     $table->dropColumn([
        //         'career_planing',
        //         'pathway_programs',
        //         'employeement_rates',
        //         'class_size_undergraduate',
        //         'class_size_masters',
        //         'service_and_guidance_new_students',
        //         'service_and_guidance_to_new_arrivals_in_canada',
        //     ]);
        //     $table->dropColumn([
          
        //         // 'work_off_campus',
        //         // 'years_before_elegible_for_pr',
        //         // 'program_type_greduates',
        //         // 'program_type_undergreduates',
        //         // 'field_of_study',
        //         'marked_facts',
        //     ]);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_quick_facts_features');
        Schema::table('school_quick_facts', function (Blueprint $table) {
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
            $table->longText('financial_aid_programs_for_province_students')->nullable();
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
            $table->longText('work_off_campus')->nullable();
            $table->longText('years_before_elegible_for_pr')->nullable();
            $table->longText('program_type_greduates')->nullable();
            $table->longText('program_type_undergreduates')->nullable();
            $table->longText('field_of_study')->nullable();
            $table->text('marked_facts')->nullable();
        });
    }
};
