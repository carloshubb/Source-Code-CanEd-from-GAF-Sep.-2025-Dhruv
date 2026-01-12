<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\DegreeResource;
use App\Http\Resources\Admin\ProgramResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolContactSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'school_contact_apply_button_link' => $this->school_contact_apply_button_link,
            'school_contact_apply_button_title' => $this->school_contact_apply_button_title,
            'school_contact_red_bar_button_link' => $this->school_contact_red_bar_button_link,
            'school_contact_red_bar_button_title' => $this->school_contact_red_bar_button_title,
            'school_contact_blue_bar_button_title' => $this->school_contact_blue_bar_button_title,
            'school_contact_blue_bar_button_link' => $this->school_contact_blue_bar_button_link,
            'contact_settings_linkedin' => $this->contact_settings_linkedin,
            'contact_settings_instagram' => $this->contact_settings_instagram,
            'contact_settings_facebook' => $this->contact_settings_facebook,
            'top_page_text' => $this->top_page_text,
            'top_photo' => $this->top_photo,
            'customer_id' => $this->customer_id ?? null,
            'created_at' => isset($this->created_at) ? date('m/d/Y H:i:s', strtotime($this->created_at)) : null,
            'school_contact_setting_detail' => isset($this->schoolContactSettingDetail) ? SchoolContactSettingDetailResource::collection($this->schoolContactSettingDetail) : null,
        ];
    }
}
