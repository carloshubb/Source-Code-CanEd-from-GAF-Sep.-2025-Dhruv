<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SchoolRequestSettingResource;
use App\Models\SchoolRequestSetting;
use App\Models\SchoolRequestSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class SchoolRequestSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $schoolRequestSetting = SchoolRequestSetting::with('schoolRequestSettingDetail')->first();

        if(!$schoolRequestSetting){
            $schoolRequestSetting = SchoolRequestSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                SchoolRequestSettingDetail::create([
                    'school_request_setting_id' => $schoolRequestSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $schoolRequestSetting = $schoolRequestSetting->loadMissing('schoolRequestSettingDetail');
        }

        return $this->successResponse(new SchoolRequestSettingResource($schoolRequestSetting), 'Data get successfully.');
    }

    public function update(Request $request)
    {
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['page_title.page_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_title.page_title_' . $language->id . '.required' => 'This field is required']);
            
            $validationRule = array_merge($validationRule, ['name_label.name_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_label.name_label_' . $language->id . '.required' => 'This field is required']);

            // $validationRule = array_merge($validationRule, ['name_placeholder.name_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['name_placeholder.name_placeholder_' . $language->id . '.required' => 'This field is required']);

            $validationRule = array_merge($validationRule, ['name_error.name_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_error.name_error_' . $language->id . '.required' => 'This field is required']);


            $validationRule = array_merge($validationRule, ['description_label.description_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['description_label.description_label_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['description_placeholder.description_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['description_placeholder.description_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['description_error.description_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['description_error.description_error_' . $language->id . '.required' => 'This field is required.']);
            
            // first name
            $validationRule = array_merge($validationRule, ['website_label.website_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['website_label.website_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['website_placeholder.website_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['website_placeholder.website_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['website_error.website_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['website_error.website_error_' . $language->id . '.required' => 'This field is required.']);

            // last name
            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['email_placeholder.email_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['email_placeholder.email_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'This field is required.']);

      
            //password
            $validationRule = array_merge($validationRule, ['phone_label.phone_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['phone_label.phone_label_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['phone_placeholder.phone_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['phone_placeholder.phone_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['phone_error.phone_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['phone_error.phone_error_' . $language->id . '.required' => 'This field is required.']);

            //confirm password
            $validationRule = array_merge($validationRule, ['time_label.time_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['time_label.time_label_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['time_placeholder.time_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['time_placeholder.time_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['time_error.time_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['time_error.time_error_' . $language->id . '.required' => 'This field is required.']);


            $validationRule = array_merge($validationRule, ['time_zone_label.time_zone_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['time_zone_label.time_zone_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['time_zone_placeholder.time_zone_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['time_zone_placeholder.time_zone_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['time_zone_error.time_zone_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['time_zone_error.time_zone_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['province_label.province_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['province_label.province_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['province_placeholder.province_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['province_placeholder.province_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['province_error.province_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['province_error.province_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['country_label.country_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_label.country_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['country_placeholder.country_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_placeholder.country_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['country_error.country_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['country_error.country_error_' . $language->id . '.required' => 'This field is required.']);



            $validationRule = array_merge($validationRule, ['city_label.city_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['city_label.city_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['city_placeholder.city_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['city_placeholder.city_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['city_error.city_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['city_error.city_error_' . $language->id . '.required' => 'This field is required.']);


            $validationRule = array_merge($validationRule, ['protect_your_account_text.protect_your_account_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['protect_your_account_text.protect_your_account_text_' . $language->id . '.required' => 'This field is required.']);
        

            $validationRule = array_merge($validationRule, ['protect_your_account_description.protect_your_account_description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['protect_your_account_description.protect_your_account_description_' . $language->id . '.required' => 'This field is required.']);
        

            $validationRule = array_merge($validationRule, ['submit_button_text.submit_button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['submit_button_text.submit_button_text_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['image_upload_label.image_upload_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['image_upload_label.image_upload_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['image_upload_placeholder.image_upload_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['image_upload_placeholder.image_upload_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['image_upload_error.image_upload_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['image_upload_error.image_upload_error_' . $language->id . '.required' => 'This field is required.']);

        
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $schoolRequestSetting = SchoolRequestSetting::firstOrCreate([]);
        $schoolRequestSetting->touch();
        foreach ($languages as $language) {
            $schoolRequestSettingDetail = SchoolRequestSettingDetail::whereLanguageId($language->id)->whereSchoolRequestSettingId($schoolRequestSetting->id)->exists();
            
            $fields = [
                'page_title' => $request['page_title']['page_title_' . $language->id] ?? null,
                'website_label' => $request['website_label']['website_label_' . $language->id] ?? null,
                'website_placeholder' => $request['website_placeholder']['website_placeholder_' . $language->id] ?? null,
                'website_error' => $request['website_error']['website_error_' . $language->id] ?? null,
                'email_label' => $request['email_label']['email_label_' . $language->id] ?? null,
                'email_placeholder' => $request['email_placeholder']['email_placeholder_' . $language->id] ?? null,
                'email_error' => $request['email_error']['email_error_' . $language->id] ?? null,
                'name_label' => $request['name_label']['name_label_' . $language->id] ?? null,
                'name_placeholder' => $request['name_placeholder']['name_placeholder_' . $language->id] ?? null,
                'name_error' => $request['name_error']['name_error_' . $language->id] ?? null,
                'description_label' => $request['description_label']['description_label_' . $language->id] ?? null,
                'description_placeholder' => $request['description_placeholder']['description_placeholder_' . $language->id] ?? null,
                'description_error' => $request['description_error']['description_error_' . $language->id] ?? null,
                'phone_label' => $request['phone_label']['phone_label_' . $language->id] ?? null,
                'phone_placeholder' => $request['phone_placeholder']['phone_placeholder_' . $language->id] ?? null,
                'phone_error' => $request['phone_error']['phone_error_' . $language->id] ?? null,
                'time_label' => $request['time_label']['time_label_' . $language->id] ?? null,
                'time_placeholder' => $request['time_placeholder']['time_placeholder_' . $language->id] ?? null,
                'time_error' => $request['time_error']['time_error_' . $language->id] ?? null,
                'time_zone_label' => $request['time_zone_label']['time_zone_label_' . $language->id] ?? null,
                'time_zone_placeholder' => $request['time_zone_placeholder']['time_zone_placeholder_' . $language->id] ?? null,
                'time_zone_error' => $request['time_zone_error']['time_zone_error_' . $language->id] ?? null,
                'province_label' => $request['province_label']['province_label_' . $language->id] ?? null,
                'province_placeholder' => $request['province_placeholder']['province_placeholder_' . $language->id] ?? null,
                'province_error' => $request['province_error']['province_error_' . $language->id] ?? null,
                'country_label' => $request['country_label']['country_label_' . $language->id] ?? null,
                'country_placeholder' => $request['country_placeholder']['country_placeholder_' . $language->id] ?? null,
                'country_error' => $request['country_error']['country_error_' . $language->id] ?? null,
                'city_label' => $request['city_label']['city_label_' . $language->id] ?? null,
                'city_placeholder' => $request['city_placeholder']['city_placeholder_' . $language->id] ?? null,
                'city_error' => $request['city_error']['city_error_' . $language->id] ?? null,
                'image_upload_label' => $request['image_upload_label']['image_upload_label_' . $language->id] ?? null,
                'image_upload_placeholder' => $request['image_upload_placeholder']['image_upload_placeholder_' . $language->id] ?? null,
                'image_upload_error' => $request['image_upload_error']['image_upload_error_' . $language->id] ?? null,
                'protect_your_account_text' => $request['protect_your_account_text']['protect_your_account_text_' . $language->id] ?? null,
                'protect_your_account_description' => $request['protect_your_account_description']['protect_your_account_description_' . $language->id] ?? null,
                'submit_button_text' => $request['submit_button_text']['submit_button_text_' . $language->id] ?? null,

            ];
            if ($schoolRequestSettingDetail) {
                SchoolRequestSettingDetail::whereLanguageId($language->id)->whereSchoolRequestSettingId($schoolRequestSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['school_request_setting_id' => $schoolRequestSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                SchoolRequestSettingDetail::create($fields);
            }
        }

        if ($schoolRequestSetting) {
            return $this->apiSuccessResponse(new SchoolRequestSettingResource($schoolRequestSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
