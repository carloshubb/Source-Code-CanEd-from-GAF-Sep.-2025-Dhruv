<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class AdmissionSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'employees_pre_description' => $this->employees_pre_description,
            'employees_post_description' => $this->employees_post_description,
            'team_pre_description' => $this->team_pre_description,
            'team_post_description' => $this->team_post_description,
            'faq_pre_description' => $this->faq_pre_description,
            'faq_post_description' => $this->faq_post_description,
            'reg_page_setting' => new AdmissionSettingResource($this->whenLoaded('admissionSetting')),
            'language_code' => $this->language_code,
        ];
    }
}
