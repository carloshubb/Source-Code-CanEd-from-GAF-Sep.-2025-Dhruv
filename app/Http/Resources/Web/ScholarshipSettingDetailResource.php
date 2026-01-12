<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class ScholarshipSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'scholarship_pre_description' => $this->scholarship_pre_description,
            'scholarship_post_description' => $this->scholarship_post_description,
            'programs_pre_description' => $this->programs_pre_description,
            'programs_post_description' => $this->programs_post_description,
            'faq_pre_description' => $this->faq_pre_description,
            'faq_post_description' => $this->faq_post_description,
            'language_code' => $this->language_code,
        ];
    }
}
