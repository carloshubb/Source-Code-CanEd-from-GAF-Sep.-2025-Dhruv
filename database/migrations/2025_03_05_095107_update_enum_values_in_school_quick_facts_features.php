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
            // Use raw SQL to modify the ENUM values
            DB::statement("ALTER TABLE `school_quick_facts_features` CHANGE `type` `type` ENUM('school_location','school_type','languages','total_undergraduates','entrance_dates','canidian_tuition_fee','international_tuition_fee','telephone','fax','school_address','start_date','online_or_distance_education','minimum_gpa','conditional_admission','number_of_graduate_programs','number_of_undergraduate_programs','number_of_students','number_of_graduate_students','number_of_undergraduate_students','study_method','delivery_mode','accomodation','work_on_campus','work_during_holidays','internship','co_op_education','job_placement','financial_aid_programs_for_domastic_students','financial_aid_programs_for_province_students','financial_aid_programs_for_international_students','research_and_dissertaion','exchange_program','degree_modifier','daycare_for_students_with_kids','elementary_school_for_students_with_kids','immigration_office_on_campus','career_planing','pathway_programs','employeement_rates','class_size_undergraduate','class_size_masters','service_and_guidance_new_students','service_and_guidance_to_new_arrivals_in_canada','work_off_campus','years_before_elegible_for_pr','program_type_greduates','program_type_undergreduates','field_of_study','quick_fact_1','quick_fact_2','quick_fact_3','quick_fact_4','quick_fact_5','quick_fact_6','quick_fact_7','quick_fact_8','quick_fact_9','quick_fact_10')");
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_quick_facts_features', function (Blueprint $table) {
            DB::statement("ALTER TABLE `school_quick_facts_features` CHANGE `type` `type` ENUM('school_location','school_type','languages','total_undergraduates','entrance_dates','canidian_tuition_fee','international_tuition_fee','telephone','fax','school_address','start_date','online_or_distance_education','minimum_gpa','conditional_admission','number_of_graduate_programs','number_of_undergraduate_programs','number_of_students','number_of_graduate_students','number_of_undergraduate_students','study_method','delivery_mode','accomodation','work_on_campus','work_during_holidays','internship','co_op_education','job_placement','financial_aid_programs_for_domastic_students','financial_aid_programs_for_province_students','financial_aid_programs_for_international_students','research_and_dissertaion','exchange_program','degree_modifier','daycare_for_students_with_kids','elementary_school_for_students_with_kids','immigration_office_on_campus','career_planing','pathway_programs','employeement_rates','class_size_undergraduate','class_size_masters','service_and_guidance_new_students','service_and_guidance_to_new_arrivals_in_canada','work_off_campus','years_before_elegible_for_pr','program_type_greduates','program_type_undergreduates','field_of_study')");
        });
    }
};
