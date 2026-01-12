<?php

namespace App\Http\Resources\Web;


use Illuminate\Http\Resources\Json\JsonResource;

class SchoolAmbassadorSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'heading_text' => $this->heading_text,
            'main_photo' => $this->main_photo,
            'customer_id' => $this->customer_id ?? null,
            'created_at' => isset($this->created_at) ? date('m/d/Y H:i:s', strtotime($this->created_at)) : null,
            'school_ambassador_setting_detail' => isset($this->schoolAmbassadorSettingDetail) ? SchoolAmbassadorSettingDetailResource::collection($this->schoolAmbassadorSettingDetail) : null,
        ];
    }
}
