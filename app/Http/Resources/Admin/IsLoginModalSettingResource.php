<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class IsLoginModalSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'is_login_modal_setting_detail' => IsLoginModalSettingDetailResource::collection($this->whenLoaded('isLoginModalSettingDetail')),
        ];
    }
}
