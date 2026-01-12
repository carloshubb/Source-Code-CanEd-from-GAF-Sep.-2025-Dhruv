<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\LoginPageSettingResource;
use App\Models\LoginPageSetting;
use App\Models\LoginPageDetailSetting;
use App\Traits\StatusResponser;
use Illuminate\Http\Request;

class LoginPageSettingController extends Controller
{
    use StatusResponser;

    public function index()
    {
        $loginPageSetting = LoginPageSetting::with('loginPageSettingDetail')->first();

        if(!$loginPageSetting){
            $loginPageSetting = LoginPageSetting::create([]);
            $languages = getAllLanguages();
            foreach ($languages as $language) {
                LoginPageDetailSetting::create([
                    'login_page_setting_id' => $loginPageSetting->id,
                    'language_id' => $language->id,
                ]);
            }
            $loginPageSetting = $loginPageSetting->loadMissing('loginPageSettingDetail');
        }

        return $this->successResponse(new LoginPageSettingResource($loginPageSetting), 'Data get successfully.');
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
            $errorMessages = array_merge($errorMessages, ['page_title.page_title_' . $language->id . '.required' => 'This field is required.']);
            $validationRule = array_merge($validationRule, ['login_email_label.login_email_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['login_email_label.login_email_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['login_email_placeholder.login_email_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['login_email_placeholder.login_email_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['login_email_error.login_email_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['login_email_error.login_email_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['login_passowrd_label.login_passowrd_label_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['login_passowrd_label.login_passowrd_label_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['login_passowrd_placeholder.login_passowrd_placeholder_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['login_passowrd_placeholder.login_passowrd_placeholder_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['login_passowrd_error.login_passowrd_error_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['login_passowrd_error.login_passowrd_error_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['keep_me_logged_in_text.keep_me_logged_in_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['keep_me_logged_in_text.keep_me_logged_in_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['forget_password_text.forget_password_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['forget_password_text.forget_password_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['login_button_text.login_button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['login_button_text.login_button_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['not_register_yet_text.not_register_yet_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['not_register_yet_text.not_register_yet_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['create_account_button_text.create_account_button_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['create_account_button_text.create_account_button_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['protect_your_account_text.protect_your_account_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['protect_your_account_text.protect_your_account_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['protect_your_account_description.protect_your_account_description_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['protect_your_account_description.protect_your_account_description_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['google_login_text.google_login_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['google_login_text.google_login_text_' . $language->id . '.required' => 'This field is required.']);
            
            $validationRule = array_merge($validationRule, ['facebook_login_text.facebook_login_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['facebook_login_text.facebook_login_text_' . $language->id . '.required' => 'This field is required.']);
            

            $validationRule = array_merge($validationRule, ['linkedin_login_text.linkedin_login_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['linkedin_login_text.linkedin_login_text_' . $language->id . '.required' => 'This field is required.']);
            

            $validationRule = array_merge($validationRule, ['email_format_error_text.email_format_error_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['email_format_error_text.email_format_error_text_' . $language->id . '.required' => 'This field is required.']);

            $validationRule = array_merge($validationRule, ['credentails_match_error_text.credentails_match_error_text_' . $language->id => [$requiredVal, 'string']]);
            $errorMessages = array_merge($errorMessages, ['credentails_match_error_text.credentails_match_error_text_' . $language->id . '.required' => 'This field is required.']);
            
            



        }

        $this->validate(
            $request,
            $validationRule,
            $errorMessages
        );

        $loginPageSetting = LoginPageSetting::first();
        $loginPageSetting->touch();
        
        foreach ($languages as $language) {
            $loginPageSettingDetail = LoginPageDetailSetting::whereLanguageId($language->id)->whereLoginPageSettingId($loginPageSetting->id)->exists();
            $fields = [
                'page_title' => $request['page_title']['page_title_' . $language->id] ?? null,
                'login_email_label' => $request['login_email_label']['login_email_label_' . $language->id] ?? null,
                'login_email_placeholder' => $request['login_email_placeholder']['login_email_placeholder_' . $language->id] ?? null,
                'login_email_error' => $request['login_email_error']['login_email_error_' . $language->id] ?? null,
                'login_passowrd_label' => $request['login_passowrd_label']['login_passowrd_label_' . $language->id] ?? null,
                'login_passowrd_placeholder' => $request['login_passowrd_placeholder']['login_passowrd_placeholder_' . $language->id] ?? null,
                'login_passowrd_error' => $request['login_passowrd_error']['login_passowrd_error_' . $language->id] ?? null,
                'keep_me_logged_in_text' => $request['keep_me_logged_in_text']['keep_me_logged_in_text_' . $language->id] ?? null,
                'forget_password_text' => $request['forget_password_text']['forget_password_text_' . $language->id] ?? null,
                'login_button_text' => $request['login_button_text']['login_button_text_' . $language->id] ?? null,
                'not_register_yet_text' => $request['not_register_yet_text']['not_register_yet_text_' . $language->id] ?? null,
                'create_account_button_text' => $request['create_account_button_text']['create_account_button_text_' . $language->id] ?? null,
                'protect_your_account_text' => $request['protect_your_account_text']['protect_your_account_text_' . $language->id] ?? null,
                'protect_your_account_description' => $request['protect_your_account_description']['protect_your_account_description_' . $language->id] ?? null,
                'facebook_login_text' => $request['facebook_login_text']['facebook_login_text_' . $language->id] ?? null,
                'google_login_text' => $request['google_login_text']['google_login_text_' . $language->id] ?? null,
                'linkedin_login_text' => $request['linkedin_login_text']['linkedin_login_text_' . $language->id] ?? null,
                'email_format_error_text' => $request['email_format_error_text']['email_format_error_text_' . $language->id] ?? null,
                'credentails_match_error_text' => $request['credentails_match_error_text']['credentails_match_error_text_' . $language->id] ?? null,
                
            ];
            if ($loginPageSettingDetail) {
                LoginPageDetailSetting::whereLanguageId($language->id)->whereLoginPageSettingId($loginPageSetting->id)->update($fields);
            } else {
                $fields = array_merge($fields, ['login_page_setting_id' => $loginPageSetting->id]);
                $fields = array_merge($fields, ['language_id' => $language->id]);
                LoginPageDetailSetting::create($fields);
            }
        }

        if ($loginPageSetting) {
            return $this->apiSuccessResponse(new LoginPageSettingResource($loginPageSetting), 'Your changes have been done successfully');
        }
        return $this->errorResponse();
    }
}
