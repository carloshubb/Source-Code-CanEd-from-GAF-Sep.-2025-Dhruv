<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolRequestSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'school_request_setting_detail' => SchoolRequestSettingDetailResource::collection($this->whenLoaded('schoolRequestSettingDetail')),
        ];
    }
}
