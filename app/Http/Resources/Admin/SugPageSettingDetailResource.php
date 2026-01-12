<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SugPageSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sug_page_setting_id' => $this->sug_page_setting_id,
            'language_id' => $this->language_id,
            'name_label' => $this->name_label,
            'name_placeholder' => $this->name_placeholder,
            'name_error' => $this->name_error,
            'email_label' => $this->email_label,
            'email_placeholder' => $this->email_placeholder,
            'email_error' => $this->email_error,
            'message_label' => $this->message_label,
            'message_placeholder' => $this->message_placeholder,
            'message_error' => $this->message_error,
            'button_text' => $this->button_text,
            'form_title' => $this->form_title,
            'sug_page_setting' => new SugPageSettingResource($this->whenLoaded('sugPageSetting')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
