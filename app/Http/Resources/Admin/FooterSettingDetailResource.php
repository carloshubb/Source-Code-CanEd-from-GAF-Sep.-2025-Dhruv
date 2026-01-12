<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class FooterSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'footer_setting_id' => $this->reg_page_setting_id,
            'language_id' => $this->language_id,
            'section_1_title' => $this->section_1_title,
            'section_2_title' => $this->section_2_title,
            'section_3_title' => $this->section_3_title,
            'section_4_title' => $this->section_4_title,
            'copy_right_text' => $this->copy_right_text,
        ];
    }
}
