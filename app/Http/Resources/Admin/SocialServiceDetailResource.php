<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialServiceDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'social_service_id' => $this->social_service_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'social_service' => new SocialServiceResource($this->whenLoaded('socialService')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
