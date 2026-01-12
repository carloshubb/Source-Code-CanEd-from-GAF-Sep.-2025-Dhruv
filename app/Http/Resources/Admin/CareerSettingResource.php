<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CareerSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'career_setting_detail' => CareerSettingDetailResource::collection($this->whenLoaded('careerSettingDetail')),
        ];
    }
}
