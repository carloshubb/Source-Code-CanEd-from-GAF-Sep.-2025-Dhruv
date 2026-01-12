<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class IsLoginModalSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'is_login_modal_setting_id' => $this->is_login_modal_setting_id,
            'language_id' => $this->language_id,
            'modal_title' => $this->modal_title,
            'login_button_text' => $this->login_button_text,
            'register_button_text' => $this->register_button_text,
            'back_button_text' => $this->back_button_text,
            'is_login_modal_setting' => new IsLoginModalSettingResource($this->whenLoaded('isLoginModalSetting')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
