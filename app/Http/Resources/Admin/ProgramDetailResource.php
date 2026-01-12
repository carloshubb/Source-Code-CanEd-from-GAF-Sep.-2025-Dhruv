<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'program_id' => $this->program_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'description' => $this->description,
            'program' => new DegreeResource($this->whenLoaded('program')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
