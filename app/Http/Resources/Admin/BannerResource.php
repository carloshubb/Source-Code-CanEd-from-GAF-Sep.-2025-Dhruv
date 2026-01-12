<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'short_code' => $this->short_code,
            'banner_image' => new MediaResource($this->Image1),
            'banner_image_2' => new MediaResource($this->Image2),
            'banner_type' => $this->banner_type,
            'banner_button_link' => $this->banner_button_link,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'banner_detail' => BannerDetailResource::collection($this->whenLoaded('BannerDetail')),
        ];
    }
}
