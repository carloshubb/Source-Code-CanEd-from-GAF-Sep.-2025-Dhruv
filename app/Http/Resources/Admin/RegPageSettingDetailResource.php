<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RegPageSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'reg_page_setting_id' => $this->reg_page_setting_id,
            'language_id' => $this->language_id,
            'page_title' => $this->page_title,
            
            'reg_first_name_label' => $this->reg_first_name_label,
            'reg_first_name_placeholder' => $this->reg_first_name_placeholder,
            'reg_first_name_error' => $this->reg_first_name_error,

            'reg_last_name_label' => $this->reg_last_name_label,
            'reg_last_name_placeholder' => $this->reg_last_name_placeholder,
            'reg_last_name_error' => $this->reg_last_name_error,

            'reg_email_label' => $this->reg_email_label,
            'reg_email_placeholder' => $this->reg_email_placeholder,
            'reg_email_error' => $this->reg_email_error,

            'reg_passowrd_label' => $this->reg_passowrd_label,
            'reg_passowrd_placeholder' => $this->reg_passowrd_placeholder,
            'reg_passowrd_error' => $this->reg_passowrd_error,

            'reg_confirm_passowrd_label' => $this->reg_confirm_passowrd_label,
            'reg_confirm_passowrd_placeholder' => $this->reg_confirm_passowrd_placeholder,
            'reg_confirm_passowrd_error' => $this->reg_confirm_passowrd_error,


            'privacy_terms_text' => $this->privacy_terms_text,
            'reg_button_text' => $this->reg_button_text,
            'already_register_yet_text' => $this->already_register_yet_text,
            'login_button_text' => $this->login_button_text,
            'protect_your_account_text' => $this->protect_your_account_text,
            'protect_your_account_description' => $this->protect_your_account_description,
            'reg_page_setting' => new RegPageSettingResource($this->whenLoaded('regPageSetting')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
