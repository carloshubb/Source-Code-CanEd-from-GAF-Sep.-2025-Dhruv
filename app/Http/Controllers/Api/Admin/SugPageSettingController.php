<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SugPageSettingResource;
use App\Models\SugPageSetting;
use App\Models\SugPageSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class SugPageSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $sugPageSetting = SugPageSetting::with('sugPageSettingDetail')->first();

        if(!$sugPageSetting){
            $sugPageSetting = SugPageSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                SugPageSettingDetail::create([
                    'sug_page_setting_id' => $sugPageSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $sugPageSetting = $sugPageSetting->loadMissing('sugPageSettingDetail');
        }

        return $this->successResponse(new SugPageSettingResource($sugPageSetting), 'Data get successfully.');
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
            $validationRule = array_merge($validationRule, ['email_label.email_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_label.email_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['email_placeholder.email_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_placeholder.email_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['email_error.email_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_error.email_error_' . $language->id . '.required' => 'This field is required.']);
            
            // first name
            $validationRule = array_merge($validationRule, ['name_label.name_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_label.name_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['name_placeholder.name_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_placeholder.name_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['name_error.name_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['name_error.name_error_' . $language->id . '.required' => 'This field is required.']);

            // last name
            $validationRule = array_merge($validationRule, ['message_label.message_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_label.message_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['message_placeholder.message_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_placeholder.message_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['message_error.message_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['message_error.message_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['button_text.button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['button_text.button_text_' . $language->id . '.required' => 'This field is required.']);
            
            $validationRule = array_merge($validationRule, ['form_title.form_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['form_title.form_title_' . $language->id . '.required' => 'This field is required.']);
            
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $sugPageSetting = SugPageSetting::first();
        $sugPageSetting->touch();
        foreach ($languages as $language) {
            $sugPageSettingDetail = SugPageSettingDetail::whereLanguageId($language->id)->whereSugPageSettingId($sugPageSetting->id)->exists();
            
            $fields = [
                'name_label' => $request['name_label']['name_label_' . $language->id],
                'name_placeholder' => $request['name_placeholder']['name_placeholder_' . $language->id],
                'name_error' => $request['name_error']['name_error_' . $language->id],
                'email_label' => $request['email_label']['email_label_' . $language->id],
                'email_placeholder' => $request['email_placeholder']['email_placeholder_' . $language->id],
                'email_error' => $request['email_error']['email_error_' . $language->id],
                'message_label' => $request['message_label']['message_label_' . $language->id],
                'message_placeholder' => $request['message_placeholder']['message_placeholder_' . $language->id],
                'message_error' => $request['message_error']['message_error_' . $language->id], 
                'button_text' => $request['button_text']['button_text_' . $language->id], 
                'form_title' => $request['form_title']['form_title_' . $language->id],                 
            ];
            if ($sugPageSettingDetail) {
                SugPageSettingDetail::whereLanguageId($language->id)->whereSugPageSettingId($sugPageSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['sug_page_setting_id' => $sugPageSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                SugPageSettingDetail::create($fields);
            }
        }

        if ($sugPageSetting) {
            return $this->apiSuccessResponse(new SugPageSettingResource($sugPageSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
