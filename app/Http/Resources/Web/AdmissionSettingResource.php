<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class AdmissionSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'admission_apply_button_link' => $this->admission_apply_button_link,
            'admission_apply_button_title' => $this->admission_apply_button_title,
            'admission_red_bar_button_link' => $this->admission_red_bar_button_link,
            'admission_red_bar_button_title' => $this->admission_red_bar_button_title,
            'admission_blue_bar_button_link' => $this->admission_blue_bar_button_link,
            'admission_blue_bar_button_title' => $this->admission_blue_bar_button_title,
            'customer_id'=>$this->customer_id ?? null,
            'created_at' => isset($this->created_at) ? date('m/d/Y H:i:s', strtotime($this->created_at)) : null,
            'admission_setting_detail' => isset($this->admissionSettingDetail) ? AdmissionSettingDetailResource::collection($this->whenLoaded('admissionSettingDetail')) : null,
        ];
    }
}
