<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolRequestSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'school_request_setting_id' => $this->school_request_setting_id,
            'language_id' => $this->language_id,
            'page_title' => $this->page_title,
            'name_label' => $this->name_label,
            'name_placeholder' => $this->name_placeholder,
            'name_error' => $this->name_error,
            'description_label' => $this->description_label,
            'description_placeholder' => $this->description_placeholder,
            'description_error' => $this->description_error,
            'website_label' => $this->website_label,
            'website_placeholder' => $this->website_placeholder,
            'website_error' => $this->website_error,
            'email_label' => $this->email_label,
            'email_placeholder' => $this->email_placeholder,
            'email_error' => $this->email_error,
            'phone_label' => $this->phone_label,
            'phone_placeholder' => $this->phone_placeholder,
            'phone_error' => $this->phone_error,
            'time_label' => $this->time_label,
            'time_placeholder' => $this->time_placeholder,
            'time_error' => $this->time_error,
            'time_zone_label' => $this->time_zone_label,
            'time_zone_placeholder' => $this->time_zone_placeholder,
            'time_zone_error' => $this->time_zone_error,
            'province_label' => $this->province_label,
            'province_placeholder' => $this->province_placeholder,
            'province_error' => $this->province_error,
            'country_label' => $this->country_label,
            'country_placeholder' => $this->country_placeholder,
            'country_error' => $this->country_error,
            'city_label' => $this->city_label,
            'city_placeholder' => $this->city_placeholder,
            'city_error' => $this->city_error,
            'image_upload_label' => $this->image_upload_label,
            'image_upload_placeholder' => $this->image_upload_placeholder,
            'image_upload_error' => $this->image_upload_error,
            'description' => $this->description,
            'protect_your_account_text' => $this->protect_your_account_text,
            'protect_your_account_description' => $this->protect_your_account_description,
            'submit_button_text' => $this->submit_button_text,
            'school_request_setting' => new SchoolRequestSettingResource($this->whenLoaded('regPageSetting')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
