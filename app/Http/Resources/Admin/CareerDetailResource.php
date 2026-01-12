<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CareerDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'career_id' => $this->career_id,
            'language_id' => $this->language_id,
            'level' => $this->level,
            'h_structure' => $this->h_structure,
            'code' => $this->code,
            'class_name' => $this->class_name,
            'class_definition' => $this->class_definition,
            'career' => new CareerResource($this->whenLoaded('career')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
