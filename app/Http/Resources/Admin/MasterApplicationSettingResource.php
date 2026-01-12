<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MasterApplicationSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'master_application_setting_detail' => MasterApplicationSettingDetailResource::collection($this->whenLoaded('masterApplicationSettingDetail')),
        ];
    }
}
