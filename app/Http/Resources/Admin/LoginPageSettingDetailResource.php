<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginPageSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'login_page_setting_id' => $this->login_page_setting_id,
            'language_id' => $this->language_id,
            'page_title' => $this->page_title,
            'login_email_label' => $this->login_email_label,
            'login_email_placeholder' => $this->login_email_placeholder,
            'login_email_error' => $this->login_email_error,
            'login_passowrd_label' => $this->login_passowrd_label,
            'login_passowrd_placeholder' => $this->login_passowrd_placeholder,
            'login_passowrd_error' => $this->login_passowrd_error,
            'keep_me_logged_in_text' => $this->keep_me_logged_in_text,
            'forget_password_text' => $this->forget_password_text,
            'login_button_text' => $this->login_button_text,
            'not_register_yet_text' => $this->not_register_yet_text,
            'create_account_button_text' => $this->create_account_button_text,
            'protect_your_account_text' => $this->protect_your_account_text,
            'protect_your_account_description' => $this->protect_your_account_description,
            'facebook_login_text' => $this->facebook_login_text,
            'google_login_text' => $this->google_login_text,
            'linkedin_login_text' => $this->linkedin_login_text,
            'email_format_error_text' => $this->email_format_error_text,
            'credentails_match_error_text' => $this->credentails_match_error_text,
            'login_page_setting' => new LoginPageSettingResource($this->whenLoaded('loginPageSetting')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
