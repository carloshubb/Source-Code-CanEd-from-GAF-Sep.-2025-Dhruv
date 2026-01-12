<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BusDirectorySettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'bus_directory_setting_id' => $this->bus_directory_setting_id,
            'language_id' => $this->language_id,
            'company_name_label' => $this->company_name_label,
            'company_name_placeholder' => $this->company_name_placeholder,
            'company_name_error' => $this->company_name_error,

            'city_label' => $this->city_label,
            'city_placeholder' => $this->city_placeholder,
            'city_error' => $this->city_error,

            'province_label' => $this->province_label,
            'province_placeholder' => $this->province_placeholder,
            'province_error' => $this->province_error,

            'industry_label' => $this->industry_label,
            'industry_placeholder' => $this->industry_placeholder,
            'industry_error' => $this->industry_error,
            'button_text' => $this->button_text,
            'bus_directory_setting' => new RegPageSettingResource($this->whenLoaded('busDirectorySetting')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
