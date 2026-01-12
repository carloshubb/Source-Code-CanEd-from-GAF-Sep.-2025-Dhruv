<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Web\AdmissionSettingResource;
use App\Models\AdmissionSetting;
use App\Models\AdmissionSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class AdmissionSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        if (isset($_GET['is_admin'])) {
            $admissionSetting = AdmissionSetting::where('school_id', $_GET['school_id'])
                ->with('admissionSettingDetail')
                ->first();
        }
        else{
            $customer = auth()
                ->guard('customers')
                ->user();
            $customerId = $customer->id ?? null;
            $admissionSetting = AdmissionSetting::where('customer_id', $customerId)
                ->with('admissionSettingDetail')
                ->first();
        }
        return $this->successResponse(isset($admissionSetting) ? new AdmissionSettingResource($admissionSetting) : null, 'Data get successfully.');
    }

    public function update(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            if ($language->is_default == 1) {
                $validationRule = array_merge($validationRule, ['employees_pre_description.employees_pre_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['employees_pre_description.employees_pre_description_' . $language->abbreviation . '.required' => 'This field is required.']);

                $validationRule = array_merge($validationRule, ['employees_post_description.employees_post_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['employees_post_description.employees_post_description_' . $language->abbreviation . '.required' => 'This field is required.']);

                $validationRule = array_merge($validationRule, ['team_pre_description.team_pre_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['team_pre_description.team_pre_description_' . $language->abbreviation . '.required' => 'This field is required.']);

                // $validationRule = array_merge($validationRule, ['admission_apply_button_link.admission_apply_button_link_' . $language->abbreviation => ['nullable', 'string']]);
                // $errorMessages = array_merge($errorMessages, ['admission_apply_button_link.admission_apply_button_link_' . $language->abbreviation . '.required' => 'This field is required.']);
                // $validationRule = array_merge($validationRule, ['admission_apply_button_title.admission_apply_button_title_' . $language->abbreviation => ['nullable', 'string']]);
                // $errorMessages = array_merge($errorMessages, ['admission_apply_button_title.admission_apply_button_title_' . $language->abbreviation . '.required' => 'This field is required.']);


                $validationRule = array_merge($validationRule, ['team_post_description.team_post_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['team_post_description.team_post_description_' . $language->abbreviation . '.required' => 'This field is required.']);

                $validationRule = array_merge($validationRule, ['faq_pre_description.faq_pre_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['faq_pre_description.faq_pre_description_' . $language->abbreviation . '.required' => 'This field is required.']);

                $validationRule = array_merge($validationRule, ['faq_post_description.faq_post_description_' . $language->abbreviation => ['nullable', 'string']]);
                $errorMessages = array_merge($errorMessages, ['faq_post_description.faq_post_description_' . $language->abbreviation . '.required' => 'This field is required.']);
            }
        }

        $this->validate($request, $validationRule, $errorMessages);
        $admissionSetting = AdmissionSetting::whereSchoolId($request->school_id)->where('customer_id', $request->customer_id)->first();
        if ($admissionSetting) {
            $update = $admissionSetting->update([
                'customer_id' => $request->customer_id,
                'school_id' => $request->school_id,
                'admission_apply_button_link' => $request->admission_apply_button_link,
                'admission_apply_button_title' => $request->admission_apply_button_title,
                'admission_red_bar_button_link' => $request->admission_red_bar_button_link,
                'admission_red_bar_button_title' => $request->admission_red_bar_button_title,
                'admission_blue_bar_button_link' => $request->admission_blue_bar_button_link,
                'admission_blue_bar_button_title' => $request->admission_blue_bar_button_title,
            ]);
        } else {
            // dd($request->customer_id, $request->school_id);
            $admissionSetting = AdmissionSetting::create([
                'customer_id' => $request->customer_id,
                'admission_apply_button_link' => $request->admission_apply_button_link,
                'admission_apply_button_title' => $request->admission_apply_button_title,
                'admission_red_bar_button_link' => $request->admission_red_bar_button_link,
                'admission_red_bar_button_title' => $request->admission_red_bar_button_title,
                'admission_blue_bar_button_link' => $request->admission_blue_bar_button_link,
                'admission_blue_bar_button_title' => $request->admission_blue_bar_button_title,
                'school_id' => $request->school_id,
            ]);
        }
        foreach ($languages as $language) {

            $admissionSettingDetail = AdmissionSettingDetail::whereLanguageCode($language->abbreviation)
                ->whereAdmissionSettingId($admissionSetting->id)
                ->exists();

            if (isset($request['employees_pre_description']['employees_pre_description_' . $language->abbreviation])) {

                $fields = [
                    'employees_pre_description' => $request['employees_pre_description']['employees_pre_description_' . $language->abbreviation],
                    'team_post_description' => $request['team_post_description']['team_post_description_' . $language->abbreviation],
                    'faq_pre_description' => $request['faq_pre_description']['faq_pre_description_' . $language->abbreviation],
                    'faq_post_description' => $request['faq_post_description']['faq_post_description_' . $language->abbreviation],
                    // 'admission_apply_button_link' => $request['admission_apply_button_link']['admission_apply_button_link_' . $language->abbreviation],
                    // 'admission_apply_button_title' => $request['admission_apply_button_title']['admission_apply_button_title_' . $language->abbreviation],
                    'employees_post_description' => $request['employees_post_description']['employees_post_description_' . $language->abbreviation],
                    'team_pre_description' => $request['team_pre_description']['team_pre_description_' . $language->abbreviation],
                ];
                if ($admissionSettingDetail) {
                    $update = AdmissionSettingDetail::whereLanguageCode($language->abbreviation)
                        ->whereAdmissionSettingId($admissionSetting->id)
                        ->update($fields);
                } else {

                    $fields = array_merge($fields, ['admission_setting_id' => $admissionSetting->id]);
                    $fields = array_merge($fields, ['language_code' => $language->abbreviation]);
                    AdmissionSettingDetail::create($fields);
                }
            }
        }

        if ($admissionSetting) {
            return $this->apiSuccessResponse(new AdmissionSettingResource($admissionSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
