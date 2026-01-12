<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\SchoolContactSettingResource;
use App\Models\SchoolContactSetting;
use App\Models\SchoolContactSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class SchoolContactSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        if (isset($_GET['is_admin'])) {
            $school = SchoolContactSetting::where('school_id', $_GET['school_id'])->with('schoolContactSettingDetail')->first();
        } else {
            $customer = auth()->guard('customers')->user();
            $customerId = $customer->id ?? null;
            $school = SchoolContactSetting::where('customer_id', $customerId)->with('schoolContactSettingDetail')->first();
        }
        return $this->successResponse(new SchoolContactSettingResource($school), 'Data get successfully.');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['main_paragraph.main_paragraph_' . $language->abbreviation => ['required', 'string']]);
                $errorMessages = array_merge($errorMessages, ['main_paragraph.main_paragraph_' . $language->abbreviation . '.required' => 'This field is required.']);
                // $validationRule = array_merge($validationRule, ['brief_description.brief_description_' . $language->abbreviation => ['required', 'string']]);
                // $errorMessages = array_merge($errorMessages, ['brief_description.brief_description_' . $language->abbreviation . '.required' => 'This field is required.']);
                $validationRule = array_merge($validationRule, [
                    'brief_description.brief_description_' . $language->abbreviation => [
                        'nullable',
                        'string',
                        function ($attribute, $value, $fail) {
                            $plainText = trim(strip_tags(html_entity_decode($value))); 
                            if (str_word_count($plainText) > 50) {
                                $fail('Only 50 words are allowed for the brief description.');
                            }
                        }
                    ]
                ]);
                
                $errorMessages = array_merge($errorMessages, [
                    'brief_description.brief_description_' . $language->abbreviation . '.required' => 'This field is required.'
                ]);
                
            }
        }
        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );
        $fields = [
            'customer_id' => $request->customer_id,
            'school_id' => $request->school_id,
            'school_contact_apply_button_link' => $request->school_contact_apply_button_link,
            'school_contact_apply_button_title' => $request->school_contact_apply_button_title,
            'school_contact_blue_bar_button_link' => $request->school_contact_blue_bar_button_link,
            'school_contact_blue_bar_button_title' => $request->school_contact_blue_bar_button_title,
            'school_contact_red_bar_button_title' => $request->school_contact_red_bar_button_title,
            'school_contact_red_bar_button_link' => $request->school_contact_red_bar_button_link,
            'top_page_text' => $request->top_page_text,
            'top_photo' => $request->top_photo,
            'contact_settings_linkedin' => $request->contact_settings_linkedin,
            'contact_settings_instagram' => $request->contact_settings_instagram,
            'contact_settings_facebook' => $request->contact_settings_facebook,
        ];
        $school = SchoolContactSetting::whereCustomerId($request->customer_id)->first();
        if ($school) {
            $school->update($fields);
        } else {
            $school = SchoolContactSetting::create($fields);
        }

        $school->touch();
        foreach ($languages as $language) {
            if (
                // !empty($request['main_paragraph']['main_paragraph_' . $language->abbreviation])
                !empty($request['main_paragraph']['main_paragraph_' . $language->abbreviation])
                // && !empty($request['brief_description']['brief_description_' . $language->abbreviation])

            ) {

                $schoolDetail = SchoolContactSettingDetail::whereLanguageCode($language->abbreviation)->whereSchoolContactSettingId($school->id)->exists();
                $fields = [
                    'main_paragraph' => $request['main_paragraph']['main_paragraph_' . $language->abbreviation],
                    // 'brief_description' => $request['brief_description']['brief_description_' . $language->abbreviation],
                ];
                if ($schoolDetail) {
                    SchoolContactSettingDetail::whereLanguageCode($language->abbreviation)->whereSchoolContactSettingId($school->id)->update($fields);
                } else {
                    $fields = array_merge($fields, ['school_contact_setting_id' => $school->id]);
                    $fields = array_merge($fields, ['language_code' => $language->abbreviation]);
                    SchoolContactSettingDetail::create($fields);
                }
            }
        }

        if ($school) {
            return $this->apiSuccessResponse(new SchoolContactSettingResource($school), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
