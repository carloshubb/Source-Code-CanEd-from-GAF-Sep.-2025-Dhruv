<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolQuickFactResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'customer_id' => $this->customer_id ?? null,
            'title_2_image' => $this->title_2_image ?? null,
            'title_2_button_link' => $this->title_2_button_link ?? null,
            'school_quick_facts_apply_button_link' => $this->school_quick_facts_apply_button_link ?? null,
            'school_quick_facts_apply_button_title' => $this->school_quick_facts_apply_button_title ?? null,
            'school_quick_facts_blue_bar_button_title' => $this->school_quick_facts_blue_bar_button_title ?? null,
            'school_quick_facts_blue_bar_button_link' => $this->school_quick_facts_blue_bar_button_link ?? null,
            'school_quick_facts_red_bar_button_title' => $this->school_quick_facts_red_bar_button_title ?? null,
            'school_quick_facts_red_bar_button_link' => $this->school_quick_facts_red_bar_button_link ?? null,
            'school_location' => $this->school_location ?? null,
            'number_of_graduate_programs' => $this->number_of_graduate_programs ?? null,
            'accomodation' => $this->accomodation ?? null,
            'career_planing' => $this->career_planing ?? null,
            'co_op_education' => $this->co_op_education ?? null,
            'conditional_admission' => $this->conditional_admission ?? null,
            'delivery_mode' => $this->delivery_mode ?? null,
            'daycare_for_students_with_kids' => $this->daycare_for_students_with_kids ?? null,
            'class_size_masters' => $this->class_size_masters ?? null,
            'class_size_undergraduate' => $this->class_size_undergraduate ?? null,
            'minimum_gpa' => $this->minimum_gpa ?? null,
            'start_date' => $this->start_date ?? null,
            'exchange_program' => $this->exchange_program ?? null,
            'start_date' => $this->start_date ?? null,
            'fax' => $this->fax ?? null,
            'employeement_rates' => $this->employeement_rates ?? null,
            'entrance_dates' => $this->entrance_dates ?? null,
            'elementary_school_for_students_with_kids' => $this->elementary_school_for_students_with_kids ?? null,
            'financial_aid_programs_for_domastic_students' => $this->financial_aid_programs_for_domastic_students ?? null,
            'financial_aid_programs_for_province_students' => $this->financial_aid_programs_for_province_students ?? null,
            'financial_aid_programs_for_international_students' => $this->financial_aid_programs_for_international_students ?? null,
            'immigration_office_on_campus' => $this->immigration_office_on_campus ?? null,
            'school_address' => $this->school_address ?? null,
            'job_placement' => $this->job_placement ?? null,
            'internship' => $this->internship ?? null,
            'telephone' => $this->telephone ?? null,
            'pathway_programs' => $this->pathway_programs ?? null,
            'online_or_distance_education' => $this->online_or_distance_education ?? null,
            'number_of_graduate_students' => $this->number_of_graduate_students ?? null,
            'number_of_undergraduate_students' => $this->number_of_undergraduate_students ?? null,
            'number_of_students' => $this->number_of_students ?? null,
            'study_method' => $this->study_method ?? null,
            'school_type' => $this->school_type ?? null,
            'research_and_dissertaion' => $this->research_and_dissertaion ?? null,
            'program_type_greduates' => $this->program_type_greduates ?? null,
            'program_type_undergreduates' => $this->program_type_undergreduates ?? null,
            'total_undergraduates' => $this->total_undergraduates ?? null,
            'number_of_undergraduate_programs' => $this->number_of_undergraduate_programs ?? null,
            'international_tuition_fee' => $this->international_tuition_fee ?? null,
            'canidian_tuition_fee' => $this->canidian_tuition_fee ?? null,
            'languages' => $this->languages ?? null,
            'years_before_elegible_for_pr' => $this->years_before_elegible_for_pr ?? null,
            'work_on_campus' => $this->work_on_campus ?? null,
            'work_off_campus' => $this->work_off_campus ?? null,
            'work_during_holidays' => $this->work_during_holidays ?? null,
            'service_and_guidance_to_new_arrivals_in_canada' => $this->service_and_guidance_to_new_arrivals_in_canada ?? null,
            'service_and_guidance_new_students' => $this->service_and_guidance_new_students ?? null,
            
            'created_at' => isset($this->created_at) ? date('m/d/Y H:i:s', strtotime($this->created_at)) : null,
            'school_quick_fact_detail' => isset($this->schoolQuickFactDetail) ? SchoolQuickFactDetailResource::collection($this->schoolQuickFactDetail) : null,
            'school_quick_fact_feature' => isset($this->schoolQuickFactsFeature) ? SchoolQuickFactsFeatureResource::collection($this->schoolQuickFactsFeature) : null,
        ];
    }
}
