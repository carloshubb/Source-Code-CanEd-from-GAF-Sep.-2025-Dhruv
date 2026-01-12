<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MasterApplicationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'confirm_email' => $this->confirm_email,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'can_school_text_you' => $this->can_school_text_you,
            'where_want_to_study' => $this->where_want_to_study,
            'country_of_citizenship' => $this->country_of_citizenship,
            'live_in_your_country_citizenship' => $this->live_in_your_country_citizenship,
            'current_residance' => $this->current_residance,
            'current_residance_status' => $this->current_residance_status,
            'mailing_address' => $this->mailing_address,
            'high_school_name' => $this->high_school_name,
            'for_demetra_or_master_app' => $this->for_demetra_or_master_app,
            'statement_of_purpose' => $this->statement_of_purpose,
            'letter_of_intent' => $this->letter_of_intent,
            'high_school_cgpa' => $this->high_school_cgpa,
            'high_school_city' => $this->high_school_city,
            'high_school_country' => $this->high_school_country,
            'when_plan_to_start' => $this->when_plan_to_start,
            'interested_in' => $this->degree,
            'would_like_to_study' => $this->would_like_to_study,
            'student_type' => $this->student_type,
            'tuition_funding_source' => $this->tuition_funding_source,
            'addtional' => $this->addtional,
            'add_anything' => $this->add_anything,
            'currently_living_in_canada' => $this->currently_living_in_canada,
            'currently_student_anywhere' => $this->currently_student_anywhere,
            'study_permit_candian_embassy' => $this->study_permit_candian_embassy,
            'send_me_a_copy' => $this->send_me_a_copy,
            'school' => $this->school,
            'messaging_app' => $this->messagingApps,
            'tests' => $this->tests,
            'other_test_1_name' => $this->other_test_1_name,
            'other_test_1_score' => $this->other_test_1_score,
            'other_test_2_name' => $this->other_test_2_name,
            'other_test_2_score' => $this->other_test_2_score,
            'other_test_3_name' => $this->other_test_3_name,
            'other_test_3_score' => $this->other_test_3_score,
            'other_test_4_name' => $this->other_test_4_name,
            'other_test_4_score' => $this->other_test_4_score,
            'other_test_5_name' => $this->other_test_5_name,
            'other_test_5_score' => $this->other_test_5_score,
        ];
    }
}
