<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PageDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'page_id' => $this->page_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'page' => new PageResource($this->whenLoaded('page')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
