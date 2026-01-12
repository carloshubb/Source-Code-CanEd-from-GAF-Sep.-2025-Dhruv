<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ComunityServiceDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'comunity_service_id' => $this->comunity_service_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'comunity_service' => new ComunityServiceResource($this->whenLoaded('comunityService')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
