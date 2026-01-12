<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SchoolFinancialResource;
use App\Models\SchoolFinancial;
use App\Models\SchoolFinancialDetail;
use App\Rules\YoutubeUrl;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class SchoolFinancialController extends Controller
{
    use StatusResponser;

    public function index()
    {
        if (isset($_GET['is_admin'])) {
            $school = SchoolFinancial::where('school_id', $_GET['school_id'])
                ->with('schoolFinancialDetail')
                ->first();
        } else {
            $customer = auth()
                ->guard('customers')
                ->user();
            $customerId = $customer->id ?? null;
            $school = SchoolFinancial::where('customer_id', $customerId)
                ->with('schoolFinancialDetail')
                ->first();
        }

        return $this->successResponse(new SchoolFinancialResource($school), 'Data get successfully.');
    }

    public function update(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['tabs_pre_description.tabs_pre_description_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['tabs_pre_description.tabs_pre_description_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['tabs_post_description.tabs_post_description_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['tabs_post_description.tabs_post_description_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['tab1_name.tab1_name_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['tab1_name.tab1_name_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['tab2_name.tab2_name_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['tab2_name.tab2_name_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['tab3_name.tab3_name_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['tab3_name.tab3_name_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['tab3_name.tab3_name_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['tab3_name.tab3_name_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['tab1_description.tab1_description_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['tab1_description.tab1_description_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['tab2_description.tab2_description_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['tab2_description.tab2_description_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['tab3_description.tab3_description_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['tab3_description.tab3_description_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['scholarship_pre_description.scholarship_pre_description_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['scholarship_pre_description.scholarship_pre_description_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['scholarship_post_description.scholarship_post_description_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['scholarship_post_description.scholarship_post_description_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['programs_pre_description.programs_pre_description_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['programs_pre_description.programs_pre_description_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['programs_post_description.programs_post_description_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['programs_post_description.programs_post_description_' . $language->abbreviation . '.required' => 'This field is required.']);

                $validationRule = array_merge($validationRule, ['faq_pre_description.faq_pre_description_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['faq_pre_description.faq_pre_description_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, ['faq_post_description.faq_post_description_' . $language->abbreviation => ['nullable']]);
                $errorMessages = array_merge($errorMessages, ['faq_post_description.faq_post_description_' . $language->abbreviation . '.required' => 'This field is required.']);
            }
        }
        $validationRule = array_merge($validationRule, ['video_url' => ['required', new YoutubeUrl()]]);
        $this->validate($request, $validationRule, $errorMessages);
        $fields = [
            'school_id' => isset($request->school_id) ? $request->school_id : '',
            'customer_id' => isset($request->customer_id) ? $request->customer_id : null,
            'video_url' => $request->video_url ?? null,
            'school_financials_apply_button_title' => $request->school_financials_apply_button_title ?? null,
            'school_financials_apply_button_link' => $request->school_financials_apply_button_link ?? null,
            'school_financials_red_bar_button_link' => $request->school_financials_red_bar_button_link ?? null,
            'school_financials_red_bar_button_title' => $request->school_financials_red_bar_button_title ?? null,
            'school_financials_blue_bar_button_link' => $request->school_financials_blue_bar_button_link ?? null,
            'school_financials_blue_bar_button_title' => $request->school_financials_blue_bar_button_title ?? null,
            'video_iframe' => isset($request->video_url) ? getVideoHtmlAttribute($request->video_url) : null,
        ];
        $school = SchoolFinancial::whereCustomerId($request->customer_id)->first();
        if ($school) {
            $school->update($fields);
        } else {
            $school = SchoolFinancial::create($fields);
        }

        $school->touch();
        foreach ($languages as $language) {
            if (!empty($request['tabs_pre_description']['tabs_pre_description_' . $language->abbreviation])) {
                $schoolDetail = SchoolFinancialDetail::whereLanguageCode($language->abbreviation)
                    ->whereSchoolFinancialId($school->id)
                    ->exists();
                $fields = [
                    'tabs_pre_description' => isset($request['tabs_pre_description']['tabs_pre_description_' . $language->abbreviation]) ? $request['tabs_pre_description']['tabs_pre_description_' . $language->abbreviation] : '',
                    'tabs_post_description' => isset($request['tabs_post_description']['tabs_post_description_' . $language->abbreviation]) ? $request['tabs_post_description']['tabs_post_description_' . $language->abbreviation] : '',
                    'tab1_name' => isset($request['tab1_name']['tab1_name_' . $language->abbreviation]) ? $request['tab1_name']['tab1_name_' . $language->abbreviation] : '',
                    'tab2_name' => isset($request['tab2_name']['tab2_name_' . $language->abbreviation]) ? $request['tab2_name']['tab2_name_' . $language->abbreviation] : '',
                    'tab3_name' => isset($request['tab3_name']['tab3_name_' . $language->abbreviation]) ? $request['tab3_name']['tab3_name_' . $language->abbreviation] : '',
                    'tab1_description' => isset($request['tab1_description']['tab1_description_' . $language->abbreviation]) ? $request['tab1_description']['tab1_description_' . $language->abbreviation] : '',
                    'tab2_description' => isset($request['tab2_description']['tab2_description_' . $language->abbreviation]) ? $request['tab2_description']['tab2_description_' . $language->abbreviation] : '',
                    'tab3_description' => isset($request['tab3_description']['tab3_description_' . $language->abbreviation]) ? $request['tab3_description']['tab3_description_' . $language->abbreviation] : '',
                    'scholarship_pre_description' => isset($request['scholarship_pre_description']['scholarship_pre_description_' . $language->abbreviation]) ? $request['scholarship_pre_description']['scholarship_pre_description_' . $language->abbreviation] : '',
                    'programs_pre_description' => isset($request['programs_pre_description']['programs_pre_description_' . $language->abbreviation]) ? $request['programs_pre_description']['programs_pre_description_' . $language->abbreviation] : '',
                    'programs_post_description' => isset($request['programs_post_description']['programs_post_description_' . $language->abbreviation]) ? $request['programs_post_description']['programs_post_description_' . $language->abbreviation] : '',
                    'scholarship_post_description' => isset($request['scholarship_post_description']['scholarship_post_description_' . $language->abbreviation]) ? $request['scholarship_post_description']['scholarship_post_description_' . $language->abbreviation] : '',
                    'faq_pre_description' => isset($request['faq_pre_description']['faq_pre_description_' . $language->abbreviation]) ? $request['faq_pre_description']['faq_pre_description_' . $language->abbreviation] : '',
                    'faq_post_description' => isset($request['faq_post_description']['faq_post_description_' . $language->abbreviation]) ? $request['faq_post_description']['faq_post_description_' . $language->abbreviation] : '',
                ];
                if ($schoolDetail) {
                    SchoolFinancialDetail::whereLanguageCode($language->abbreviation)
                        ->whereSchoolFinancialId($school->id)
                        ->update($fields);
                } else {
                    $fields = array_merge($fields, ['school_financial_id' => $school->id]);
                    $fields = array_merge($fields, ['language_code' => $language->abbreviation]);
                    SchoolFinancialDetail::create($fields);
                }
            }
        }

        if ($school) {
            return $this->apiSuccessResponse(new SchoolFinancialResource($school), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
