<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'banner_id' => $this->banner_id,
            'language_id' => $this->language_id,
            'title' => $this->title,
            'banner_description' => $this->banner_description,
            'banner_button_text' => $this->banner_button_text,
            'banner' => new BannerResource($this->whenLoaded('banner')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
