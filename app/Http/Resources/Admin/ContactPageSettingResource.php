<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactPageSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'contact_page_setting_detail' => ContactPageSettingDetailResource::collection($this->whenLoaded('contactPageSettingDetail')),
        ];
    }
}
