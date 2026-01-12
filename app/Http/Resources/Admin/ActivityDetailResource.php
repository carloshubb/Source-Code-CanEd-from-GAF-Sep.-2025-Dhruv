<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'activity_id' => $this->activity_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}