<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProximaRequestSettingResource;
use App\Models\ProximaRequestSetting;
use App\Models\ProximaRequestSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;


class ProximaRequestSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $proximaRequestSetting = ProximaRequestSetting::with('proximaRequestSettingDetail')->first();

        if(!$proximaRequestSetting){
            $proximaRequestSetting = ProximaRequestSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                ProximaRequestSettingDetail::create([
                    'prox_req_set_id' => $proximaRequestSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $proximaRequestSetting = $proximaRequestSetting->loadMissing('proximaRequestSettingDetail');
        }

        return $this->successResponse(new ProximaRequestSettingResource($proximaRequestSetting), 'Data get successfully.');
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
            $validationRule = array_merge($validationRule, ['call_to_action_text.call_to_action_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['call_to_action_text.call_to_action_text_' . $language->id . '.required' => 'This field is required.']);
            
            $validationRule = array_merge($validationRule, ['name_label.name_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_label.name_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['name_placeholder.name_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_placeholder.name_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['name_error.name_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_error.name_error_' . $language->id . '.required' => 'This field is required.']);
            
            // first name
            $validationRule = array_merge($validationRule, ['phone_label.phone_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['phone_label.phone_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['phone_placeholder.phone_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['phone_placeholder.phone_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['phone_error.phone_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['phone_error.phone_error_' . $language->id . '.required' => 'This field is required.']);

            // last name
            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['email_placeholder.email_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_placeholder.email_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'This field is required.']);

      
            //password
            $validationRule = array_merge($validationRule, ['inquiry_label.inquiry_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['inquiry_label.inquiry_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['inquiry_placeholder.inquiry_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['inquiry_placeholder.inquiry_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['inquiry_error.inquiry_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['inquiry_error.inquiry_error_' . $language->id . '.required' => 'This field is required.']);

            //confirm password
            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'This field is required.']);

            
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $proximaRequestSetting = ProximaRequestSetting::firstOrCreate();
        $proximaRequestSetting->touch();
        foreach ($languages as $language) {
            $proximaRequestSettingDetail = ProximaRequestSettingDetail::whereLanguageId($language->id)->where('prox_req_set_id',$proximaRequestSetting->id)->exists();
            
            $fields = [
                'call_to_action_text' => $request['call_to_action_text']['call_to_action_text_' . $language->id] ?? null,
                'phone_label' => $request['phone_label']['phone_label_' . $language->id]?? null,
                'phone_placeholder' => $request['phone_placeholder']['phone_placeholder_' . $language->id] ?? null,
                'phone_error' => $request['phone_error']['phone_error_' . $language->id] ?? null,
                'email_label' => $request['email_label']['email_label_' . $language->id] ?? null,
                'email_placeholder' => $request['email_placeholder']['email_placeholder_' . $language->id] ?? null,
                'email_error' => $request['email_error']['email_error_' . $language->id] ?? null,
                'name_label' => $request['name_label']['name_label_' . $language->id] ?? null,
                'name_placeholder' => $request['name_placeholder']['name_placeholder_' . $language->id] ?? null,
                'name_error' => $request['name_error']['name_error_' . $language->id] ?? null,
                'inquiry_label' => $request['inquiry_label']['inquiry_label_' . $language->id] ?? null,
                'inquiry_placeholder' => $request['inquiry_placeholder']['inquiry_placeholder_' . $language->id] ?? null,
                'inquiry_error' => $request['inquiry_error']['inquiry_error_' . $language->id] ?? null,
                'button_text' => $request['button_text']['button_text_' . $language->id] ?? null,
            ];
            if ($proximaRequestSettingDetail) {
                ProximaRequestSettingDetail::whereLanguageId($language->id)->where('prox_req_set_id',$proximaRequestSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['prox_req_set_id' => $proximaRequestSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                ProximaRequestSettingDetail::create($fields);
            }
        }

        if ($proximaRequestSetting) {
            return $this->apiSuccessResponse(new ProximaRequestSettingResource($proximaRequestSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
