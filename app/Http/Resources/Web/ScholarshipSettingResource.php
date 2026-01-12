<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\DegreeResource;
use App\Http\Resources\Admin\ProgramResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ScholarshipSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'customer_id' => $this->customer_id ?? null,
            'video_url' => $this->video_url ?? null,
            'top_page_video_url' => $this->top_page_video_url ?? null,
            'scholarship_settings_apply_button_link' => $this->scholarship_settings_apply_button_link ?? null,
            'scholarship_settings_apply_button_title' => $this->scholarship_settings_apply_button_title ?? null,
            'scholarship_settings_blue_bar_button_title' => $this->scholarship_settings_blue_bar_button_title ?? null,
            'scholarship_settings_blue_bar_button_link' => $this->scholarship_settings_blue_bar_button_link ?? null,
            'scholarship_settings_red_bar_button_title' => $this->scholarship_settings_red_bar_button_title ?? null,
            'scholarship_settings_red_bar_button_link' => $this->scholarship_settings_red_bar_button_link ?? null,
            'video_iframe' => $this->video_iframe ?? null,
            'created_at' => isset($this->created_at) ? date('m/d/Y H:i:s', strtotime($this->created_at)) : null,
            'scholarship_setting_detail' => isset($this->scholarshipSettingDetail) ? ScholarshipSettingDetailResource::collection($this->scholarshipSettingDetail) : null,
        ];
    }
}
