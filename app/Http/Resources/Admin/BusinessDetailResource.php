<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'business_id' => $this->business_id,
            'language_id' => $this->language_id,
            'business_name' => $this->business_name,
            'description' => $this->description,
            'detail_description' => $this->detail_description,
            'media_section_title' => $this->media_section_title,
            'media_section_description' => $this->media_section_description,
            'bussiness' => new BusinessResource($this->whenLoaded('bussiness')),
            'language' => new   LanguageResource($this->whenLoaded('language')),
        ];
    }
}
