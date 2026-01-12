<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SchoolQuickFactResource;
use App\Models\SchoolQuickFact;
use App\Models\SchoolQuickFactDetail;
use App\Models\SchoolQuickFactsFeature;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class SchoolQuickFactController extends Controller
{
    use StatusResponser;

    public function index()
    {
        if (isset($_GET['is_admin'])) {
            $school = SchoolQuickFact::where('school_id', $_GET['school_id'])
                ->with('schoolQuickFactDetail')
                ->with('schoolQuickFactsFeature')
                ->first();
        } else {
            $customer = auth()
                ->guard('customers')
                ->user();
            $school = SchoolQuickFact::where('customer_id', $customer->id)
                ->with('schoolQuickFactDetail')
                ->with('schoolQuickFactsFeature')
                ->first();
        }

        return $this->successResponse(isset($school) ? new SchoolQuickFactResource($school) : null, 'Data get successfully.');
    }

    public function update(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['title_1.title_1_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['title_1.title_1_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['title_1_paragraph.title_1_paragraph_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['title_1_paragraph.title_1_paragraph_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['title_2.title_2_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['title_2.title_2_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['title_2_subtitle.title_2_subtitle_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['title_2_subtitle.title_2_subtitle_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['title_2_paragraph.title_2_paragraph_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['title_2_paragraph.title_2_paragraph_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['title_2_button_title.title_2_button_title_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['title_2_button_title.title_2_button_title_' . $language->abbreviation . '.required' => 'This field is required.']);
            }
        }
        // $validationRule = array_merge($validationRule, ['title_2_image' => ['required', 'string']]);
        // $errorMessages = array_merge($errorMessages, ['title_2_image.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['title_2_button_link' => ['required', 'string']]);
        $errorMessages = array_merge($errorMessages, ['title_2_button_link.required' => 'This field is required.']);
        $validationRule = array_merge($validationRule, ['telephone' => ['nullable']]);
        $errorMessages = array_merge($errorMessages, ['telephone.nullable' => 'This field is required.']);
        $this->validate($request, $validationRule, $errorMessages);
        $fields = [
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
            'title_2_image' => $request->title_2_image,
            'school_quick_facts_apply_button_link' => $request->school_quick_facts_apply_button_link,
            'school_quick_facts_apply_button_title' => $request->school_quick_facts_apply_button_title,
            'school_quick_facts_blue_bar_button_title' => $request->school_quick_facts_blue_bar_button_title,
            'school_quick_facts_blue_bar_button_link' => $request->school_quick_facts_blue_bar_button_link,
            'school_quick_facts_red_bar_button_title' => $request->school_quick_facts_red_bar_button_title,
            'school_quick_facts_red_bar_button_link' => $request->school_quick_facts_red_bar_button_link,
            'title_2_button_link' => $request->title_2_button_link,
        ];
        $school = SchoolQuickFact::whereCustomerId($request->customer_id)->first();
        if ($school) {
            $school->update($fields);
        } else {
            $school = SchoolQuickFact::create($fields);
        }
        $quickFacts = ['school_location', 'school_type', 'languages', 'total_undergraduates', 'entrance_dates', 'canidian_tuition_fee', 'international_tuition_fee', 'telephone', 'fax', 'school_address', 'start_date', 'online_or_distance_education', 'minimum_gpa', 'conditional_admission', 'number_of_graduate_programs', 'number_of_undergraduate_programs', 'number_of_students', 'number_of_graduate_students', 'number_of_undergraduate_students', 'study_method', 'delivery_mode', 'accomodation', 'work_on_campus', 'work_during_holidays', 'internship', 'co_op_education', 'job_placement', 'financial_aid_programs_for_domastic_students', 'financial_aid_programs_for_province_students', 'financial_aid_programs_for_international_students', 'research_and_dissertaion', 'exchange_program', 'degree_modifier', 'daycare_for_students_with_kids', 'elementary_school_for_students_with_kids', 'immigration_office_on_campus', 'career_planing', 'pathway_programs', 'employeement_rates', 'class_size_undergraduate', 'class_size_masters', 'service_and_guidance_new_students', 'service_and_guidance_to_new_arrivals_in_canada', 'work_off_campus', 'years_before_elegible_for_pr', 'program_type_greduates', 'program_type_undergreduates', 'field_of_study',"quick_fact_1","quick_fact_2","quick_fact_3","quick_fact_4","quick_fact_5","quick_fact_6","quick_fact_7","quick_fact_8","quick_fact_9","quick_fact_10"];

        foreach ($quickFacts as $key => $quickFact) {
            if (isset($request[$quickFact])) {
                // dd($request[$quickFact]['class_size_undergraduate'] );
                $feature = SchoolQuickFactsFeature::where('type', $quickFact)->where('school_quick_fact_id', $school->id)->first();
                if ($feature) {
                    $feature->update([
                        'value' => $request[$quickFact] ?? null,
                        'is_featured' => $request[$quickFact . '_featured'] ?? 0,
                        'sorting_order' => $request[$quickFact . '_order'] ?? null,
                    ]);
                } else {
                    SchoolQuickFactsFeature::create([
                        'school_quick_fact_id' => $school->id,
                        'type' => $quickFact,
                        'value' => $request[$quickFact] ?? null,
                        'is_featured' => $request[$quickFact . '_featured'] ?? 0,
                        'sorting_order' => $request[$quickFact . '_order'] ?? null,
                    ]);
                }
            }
        }

        $school->touch();
        foreach ($languages as $language) {
            if (!empty($request['title_1']['title_1_' . $language->abbreviation])) {
                $schoolDetail = SchoolQuickFactDetail::whereLanguageCode($language->abbreviation)
                    ->whereSchoolQuickFactId($school->id)
                    ->exists();
                $fields = [
                    'title_1' => $request['title_1']['title_1_' . $language->abbreviation],
                    'title_2_subtitle' => $request['title_2_subtitle']['title_2_subtitle_' . $language->abbreviation],
                    'title_2_paragraph' => $request['title_2_paragraph']['title_2_paragraph_' . $language->abbreviation],
                    'title_1_paragraph' => $request['title_1_paragraph']['title_1_paragraph_' . $language->abbreviation],
                    'title_2_button_title' => $request['title_2_button_title']['title_2_button_title_' . $language->abbreviation],
                    'title_2' => $request['title_2']['title_2_' . $language->abbreviation],
                ];
                if ($schoolDetail) {
                    SchoolQuickFactDetail::whereLanguageCode($language->abbreviation)
                        ->whereSchoolQuickFactId($school->id)
                        ->update($fields);
                } else {
                    $fields = array_merge($fields, ['school_quick_fact_id' => $school->id]);
                    $fields = array_merge($fields, ['language_code' => $language->abbreviation]);
                    SchoolQuickFactDetail::create($fields);
                }
            }
        }

        if ($school) {
            return $this->apiSuccessResponse(new SchoolQuickFactResource($school), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
