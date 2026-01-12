<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class NetworkDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'network_id' => $this->network_id,
            'language_id' => $this->language_id,
            'full_name' => $this->full_name,
            'description' => $this->description,
            'network' => new NetworkResource($this->whenLoaded('network')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
