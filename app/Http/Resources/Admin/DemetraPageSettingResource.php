<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DemetraPageSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'demetra_page_setting_detail' => DemetraPageSettingDetailResource::collection($this->whenLoaded('demetraPageSettingDetail')),
        ];
    }
}
