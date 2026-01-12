<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DegreeDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'degree_id' => $this->degree_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'degree' => new DegreeResource($this->whenLoaded('degree')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
