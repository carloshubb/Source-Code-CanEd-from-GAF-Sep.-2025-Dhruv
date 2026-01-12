<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class EventDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_id' => $this->event_id,
            'language_id' => $this->language_id,
            'title' => $this->title,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'event' => new EventResource($this->whenLoaded('event')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
