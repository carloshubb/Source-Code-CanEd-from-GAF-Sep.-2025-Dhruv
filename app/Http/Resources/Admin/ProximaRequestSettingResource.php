<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProximaRequestSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'proxima_request_setting_detail' => ProximaRequestSettingDetailResource::collection($this->whenLoaded('proximaRequestSettingDetail')),
        ];
    }
}
