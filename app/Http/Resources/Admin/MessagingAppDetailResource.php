<?php

namespace App\Http\Resources\Admin;
use Illuminate\Http\Resources\Json\JsonResource;

class MessagingAppDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'messaging_app_id' => $this->messaging_app_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'messaging_app' => new MessagingAppResource($this->whenLoaded('messagingApp')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
