<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProximaRequestSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'prox_req_set_id' => $this->prox_req_set_id,
            'language_id' => $this->language_id,
            'call_to_action_text' => $this->call_to_action_text,
            
            'name_label' => $this->name_label,
            'name_placeholder' => $this->name_placeholder,
            'name_error' => $this->name_error,

            'phone_label' => $this->phone_label,
            'phone_placeholder' => $this->phone_placeholder,
            'phone_error' => $this->phone_error,

            'email_label' => $this->email_label,
            'email_placeholder' => $this->email_placeholder,
            'email_error' => $this->email_error,

            'inquiry_label' => $this->inquiry_label,
            'inquiry_placeholder' => $this->inquiry_placeholder,
            'inquiry_error' => $this->inquiry_error,

            'button_text' => $this->button_text,
            'proxima_request_setting' => new ProximaRequestSettingResource($this->whenLoaded('proximaRequestSetting')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
