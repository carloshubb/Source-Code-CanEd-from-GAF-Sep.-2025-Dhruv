<?php
namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\ScholarshipSettingResource;
use App\Models\ScholarshipSetting;
use App\Models\ScholarshipSettingDetail;
use App\Rules\YoutubeUrl;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class ScholarshipSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        if (isset($_GET['is_admin'])) {
            $school = ScholarshipSetting::where('school_id', $_GET['school_id'])
                ->with('scholarshipSettingDetail')
                ->first();

            return $this->successResponse(new ScholarshipSettingResource($school), 'Data get successfully.');
        } else {
            $customer = auth()
                ->guard('customers')
                ->user();
                $customerId = $customer->id ?? null;
            $school = ScholarshipSetting::where('customer_id', $customerId)
                ->with('scholarshipSettingDetail')
                ->first();

            return $this->successResponse(new ScholarshipSettingResource($school), 'Data get successfully.');
        }
    }

    public function update(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['scholarship_pre_description.scholarship_pre_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['scholarship_pre_description.scholarship_pre_description_' . $language->abbreviation . '.required' => 'This field is required.']);

                $validationRule = array_merge($validationRule, ['scholarship_post_description.scholarship_post_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['scholarship_post_description.scholarship_post_description_' . $language->abbreviation . '.required' => 'This field is required.']);

                $validationRule = array_merge($validationRule, ['programs_pre_description.programs_pre_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['programs_pre_description.programs_pre_description_' . $language->abbreviation . '.required' => 'This field is required.']);

                $validationRule = array_merge($validationRule, ['programs_post_description.programs_post_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['programs_post_description.programs_post_description_' . $language->abbreviation . '.required' => 'This field is required.']);

                $validationRule = array_merge($validationRule, ['faq_pre_description.faq_pre_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['faq_pre_description.faq_pre_description_' . $language->abbreviation . '.required' => 'This field is required.']);

                $validationRule = array_merge($validationRule, ['faq_post_description.faq_post_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['faq_post_description.faq_post_description_' . $language->abbreviation . '.required' => 'This field is required.']);

            }
        }
        $validationRule = array_merge($validationRule, ['video_url' => ['required', new YoutubeUrl()]]);
        $validationRule = array_merge($validationRule, ['top_page_video_url' => ['required', new YoutubeUrl()]]);
        $this->validate($request, $validationRule, $errorMessages);
        $fields = [
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
            'video_url' => $request->video_url,
            'top_page_video_url' => $request->top_page_video_url,
            'scholarship_settings_apply_button_link' => $request->scholarship_settings_apply_button_link,
            'scholarship_settings_apply_button_title' => $request->scholarship_settings_apply_button_title,
            'scholarship_settings_blue_bar_button_title' => $request->scholarship_settings_blue_bar_button_title,
            'scholarship_settings_blue_bar_button_link' => $request->scholarship_settings_blue_bar_button_link,
            'scholarship_settings_red_bar_button_title' => $request->scholarship_settings_red_bar_button_title,
            'scholarship_settings_red_bar_button_link' => $request->scholarship_settings_red_bar_button_link,
            'video_iframe' => isset($request->video_url) ? getVideoHtmlAttribute($request->video_url) : null,
        ];
        $school = ScholarshipSetting::whereCustomerId($request->customer_id)->first();
        if ($school) {
            $school->update($fields);
        } else {
            $school = ScholarshipSetting::create($fields);
        }

        $school->touch();
        foreach ($languages as $language) {
            if (!empty($request['scholarship_pre_description']['scholarship_pre_description_' . $language->abbreviation])) {
                $schoolDetail = ScholarshipSettingDetail::whereLanguageCode($language->abbreviation)
                    ->whereScholarshipSettingId($school->id)
                    ->exists();
                $fields = [
                    'scholarship_pre_description' => $request['scholarship_pre_description']['scholarship_pre_description_' . $language->abbreviation] ?? null,
                    'scholarship_post_description' => $request['scholarship_post_description']['scholarship_post_description_' . $language->abbreviation] ?? null,
                    'programs_pre_description' => $request['programs_pre_description']['programs_pre_description_' . $language->abbreviation] ?? null,
                    'programs_post_description' => $request['programs_post_description']['programs_post_description_' . $language->abbreviation] ?? null,
                    'faq_pre_description' => $request['faq_pre_description']['faq_pre_description_' . $language->abbreviation] ?? null,
                    'faq_post_description' => $request['faq_post_description']['faq_post_description_' . $language->abbreviation] ?? null,
                ];
                if ($schoolDetail) {
                    ScholarshipSettingDetail::whereLanguageCode($language->abbreviation)
                        ->whereScholarshipSettingId($school->id)
                        ->update($fields);
                } else {
                    $fields = array_merge($fields, ['scholarship_setting_id' => $school->id]);
                    $fields = array_merge($fields, ['language_code' => $language->abbreviation]);
                    ScholarshipSettingDetail::create($fields);
                }
            }
        }

        if ($school) {
            return $this->apiSuccessResponse(new ScholarshipSettingResource($school), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
