<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'team_id' => $this->team_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'title' => $this->title,
            'team' => new TeamResource($this->whenLoaded('team')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
