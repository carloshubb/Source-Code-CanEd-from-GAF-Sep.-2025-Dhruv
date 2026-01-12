<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StoryDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'story_id' => $this->story_id,
            'language_id' => $this->language_id,
            'title' => $this->title,
            'story' => $this->story,
            'slug' => $this->slug,
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
