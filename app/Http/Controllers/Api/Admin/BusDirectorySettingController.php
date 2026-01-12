<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BusDirectorySettingResource;
use App\Models\BusDirectorySetting;
use App\Models\BusDirectorySettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class BusDirectorySettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $busDirectorySetting = BusDirectorySetting::with('busDirectorySettingDetail')->first();

        if(!$busDirectorySetting){
            $busDirectorySetting = BusDirectorySetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                BusDirectorySettingDetail::create([
                    'bus_directory_setting_id' => $busDirectorySetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $busDirectorySetting = $busDirectorySetting->loadMissing('busDirectorySettingDetail');
        }

        return $this->successResponse(new BusDirectorySettingResource($busDirectorySetting), 'Data get successfully.');
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
            $validationRule = array_merge($validationRule, ['company_name_label.company_name_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['company_name_label.company_name_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['company_name_placeholder.company_name_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['company_name_placeholder.company_name_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['company_name_error.company_name_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['company_name_error.company_name_error_' . $language->id . '.required' => 'This field is required.']);
            
            // first name
            $validationRule = array_merge($validationRule, ['city_label.city_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['city_label.city_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['city_placeholder.city_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['city_placeholder.city_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['city_error.city_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['city_error.city_error_' . $language->id . '.required' => 'This field is required.']);

            // last name
            $validationRule = array_merge($validationRule, ['province_label.province_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['province_label.province_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['province_placeholder.province_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['province_placeholder.province_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['province_error.province_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['province_error.province_error_' . $language->id . '.required' => 'This field is required.']);

      
            //password
            $validationRule = array_merge($validationRule, ['industry_label.industry_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['industry_label.industry_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['industry_placeholder.industry_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['industry_placeholder.industry_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['industry_error.industry_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['industry_error.industry_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'This field is required.']);  
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $busDirectorySetting = BusDirectorySetting::firstOrCreate();
        $busDirectorySetting->touch();
        foreach ($languages as $language) {
            $busDirectorySettingDetail = BusDirectorySettingDetail::whereLanguageId($language->id)->whereBusDirectorySettingId($busDirectorySetting->id)->exists();
            
            $fields = [
                'city_label' => $request['city_label']['city_label_' . $language->id],
                'city_placeholder' => $request['city_placeholder']['city_placeholder_' . $language->id],
                'city_error' => $request['city_error']['city_error_' . $language->id],
                'province_label' => $request['province_label']['province_label_' . $language->id],
                'province_placeholder' => $request['province_placeholder']['province_placeholder_' . $language->id],
                'province_error' => $request['province_error']['province_error_' . $language->id],
                'company_name_label' => $request['company_name_label']['company_name_label_' . $language->id],
                'company_name_placeholder' => $request['company_name_placeholder']['company_name_placeholder_' . $language->id],
                'company_name_error' => $request['company_name_error']['company_name_error_' . $language->id],
                'industry_label' => $request['industry_label']['industry_label_' . $language->id],
                'industry_placeholder' => $request['industry_placeholder']['industry_placeholder_' . $language->id],
                'industry_error' => $request['industry_error']['industry_error_' . $language->id],
                'button_text' => $request['button_text']['button_text_' . $language->id],
            ];
            if ($busDirectorySettingDetail) {
                BusDirectorySettingDetail::whereLanguageId($language->id)->whereBusDirectorySettingId($busDirectorySetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['bus_directory_setting_id' => $busDirectorySetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                BusDirectorySettingDetail::create($fields);
            }
        }

        if ($busDirectorySetting) {
            return $this->apiSuccessResponse(new BusDirectorySettingResource($busDirectorySetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
