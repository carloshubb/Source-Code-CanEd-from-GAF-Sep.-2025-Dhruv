<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RegPageSettingResource;
use App\Models\RegPageSetting;
use App\Models\RegPageSettingDetail;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class RegPageSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $regPageSetting = RegPageSetting::with('regPageSettingDetail')->first();

        if(!$regPageSetting){
            $regPageSetting = RegPageSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                RegPageSettingDetail::create([
                    'reg_page_setting_id' => $regPageSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $regPageSetting = $regPageSetting->loadMissing('regPageSettingDetail');
        }

        return $this->successResponse(new RegPageSettingResource($regPageSetting), 'Data get successfully.');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $validationRule = [];
        $errorMessages = [];
        $languages = getAllLanguages();
        foreach ($languages as $language) {
            $requiredVal = 'nullable';
            if ($language->is_default == '1') {
                $requiredVal = 'required';
            }
            $validationRule = array_merge($validationRule, ['page_title.page_title_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['page_title.page_title_' . $language->id . '.required' => 'This field is required.']);
            
            $validationRule = array_merge($validationRule, ['reg_email_label.reg_email_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['reg_email_label.reg_email_label_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['reg_email_placeholder.reg_email_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['reg_email_placeholder.reg_email_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['reg_email_error.reg_email_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['reg_email_error.reg_email_error_' . $language->id . '.required' => 'This field is required.']);
            
            // first name
            $validationRule = array_merge($validationRule, ['reg_first_name_label.reg_first_name_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['reg_first_name_label.reg_first_name_label_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['reg_first_name_placeholder.reg_first_name_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['reg_first_name_placeholder.reg_first_name_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['reg_first_name_error.reg_first_name_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['reg_first_name_error.reg_first_name_error_' . $language->id . '.required' => 'This field is required.']);

            // last name
            $validationRule = array_merge($validationRule, ['reg_last_name_label.reg_last_name_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['reg_last_name_label.reg_last_name_label_' . $language->id . '.required' => 'This field is required.']);

            // $validationRule = array_merge($validationRule, ['reg_last_name_placeholder.reg_last_name_placeholder_' . $language->id => [$requiredVal, 'string']]);
            // $errorMessages = array_merge($errorMessages, ['reg_last_name_placeholder.reg_last_name_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['reg_last_name_error.reg_last_name_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['reg_last_name_error.reg_last_name_error_' . $language->id . '.required' => 'This field is required.']);

      
            //password
            $validationRule = array_merge($validationRule, ['reg_passowrd_label.reg_passowrd_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['reg_passowrd_label.reg_passowrd_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['reg_passowrd_placeholder.reg_passowrd_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['reg_passowrd_placeholder.reg_passowrd_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['reg_passowrd_error.reg_passowrd_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['reg_passowrd_error.reg_passowrd_error_' . $language->id . '.required' => 'This field is required.']);

            //confirm password
            $validationRule = array_merge($validationRule, ['reg_confirm_passowrd_label.reg_confirm_passowrd_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['reg_confirm_passowrd_label.reg_confirm_passowrd_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['reg_confirm_passowrd_placeholder.reg_confirm_passowrd_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['reg_confirm_passowrd_placeholder.reg_confirm_passowrd_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['reg_confirm_passowrd_error.reg_confirm_passowrd_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['reg_confirm_passowrd_error.reg_confirm_passowrd_error_' . $language->id . '.required' => 'This field is required.']);


            $validationRule = array_merge($validationRule, ['privacy_terms_text.privacy_terms_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['privacy_terms_text.privacy_terms_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['reg_button_text.reg_button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['reg_button_text.reg_button_text_' . $language->id . '.required' => 'This field is required.']);            
        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $regPageSetting = RegPageSetting::first();
        $regPageSetting->touch();
        foreach ($languages as $language) {
            $regPageSettingDetail = RegPageSettingDetail::whereLanguageId($language->id)->whereRegPageSettingId($regPageSetting->id)->exists();
            
            $fields = [
                'page_title' => $request['page_title']['page_title_' . $language->id] ?? null,
                'reg_first_name_label' => $request['reg_first_name_label']['reg_first_name_label_' . $language->id] ?? null,
                'reg_first_name_placeholder' => $request['reg_first_name_placeholder']['reg_first_name_placeholder_' . $language->id] ?? null,
                'reg_first_name_error' => $request['reg_first_name_error']['reg_first_name_error_' . $language->id] ?? null,
                'reg_last_name_label' => $request['reg_last_name_label']['reg_last_name_label_' . $language->id] ?? null,
                'reg_last_name_placeholder' => $request['reg_last_name_placeholder']['reg_last_name_placeholder_' . $language->id] ?? null,
                'reg_last_name_error' => $request['reg_last_name_error']['reg_last_name_error_' . $language->id] ?? null,
                'reg_email_label' => $request['reg_email_label']['reg_email_label_' . $language->id] ?? null,
                'reg_email_placeholder' => $request['reg_email_placeholder']['reg_email_placeholder_' . $language->id] ?? null,
                'reg_email_error' => $request['reg_email_error']['reg_email_error_' . $language->id] ?? null,
                'reg_passowrd_label' => $request['reg_passowrd_label']['reg_passowrd_label_' . $language->id] ?? null,
                'reg_passowrd_placeholder' => $request['reg_passowrd_placeholder']['reg_passowrd_placeholder_' . $language->id] ?? null,
                'reg_passowrd_error' => $request['reg_passowrd_error']['reg_passowrd_error_' . $language->id] ?? null,
                'reg_confirm_passowrd_label' => $request['reg_confirm_passowrd_label']['reg_confirm_passowrd_label_' . $language->id] ?? null,
                'reg_confirm_passowrd_placeholder' => $request['reg_confirm_passowrd_placeholder']['reg_confirm_passowrd_placeholder_' . $language->id] ?? null,
                'reg_confirm_passowrd_error' => $request['reg_confirm_passowrd_error']['reg_confirm_passowrd_error_' . $language->id] ?? null,
                'privacy_terms_text' => $request['privacy_terms_text']['privacy_terms_text_' . $language->id] ?? null,
                'reg_button_text' => $request['reg_button_text']['reg_button_text_' . $language->id] ?? null,
            ];
            
            if ($regPageSettingDetail) {
                RegPageSettingDetail::whereLanguageId($language->id)->whereRegPageSettingId($regPageSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['reg_page_setting_id' => $regPageSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                RegPageSettingDetail::create($fields);
            }
        }

        if ($regPageSetting) {
            return $this->apiSuccessResponse(new RegPageSettingResource($regPageSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
