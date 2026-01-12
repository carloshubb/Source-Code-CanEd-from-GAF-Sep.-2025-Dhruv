<?php

namespace App\Http\Resources\Admin;

use App\Models\CookieSettingMenu;
use Illuminate\Http\Resources\Json\JsonResource;

class CookieSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'cookie_setting_detail' => CookieSettingDetailResource::collection($this->whenLoaded('cookieSettingDetail')),
        ];
    }
}
