<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SportDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sport_id' => $this->sport_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'sport' => new SportResource($this->whenLoaded('sport')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
