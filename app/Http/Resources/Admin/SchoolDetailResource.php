<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'school_id' => $this->school_id,
            'language_code' => $this->language_code,
            'school_name' => $this->school_name,
            'description' => $this->description,
            'more_button_title' => $this->more_button_title,
            'more_button_title' => $this->more_button_title,
            'more_button_sub_title' => $this->more_button_sub_title,
            'other_button_title' => $this->other_button_title,
            'school' => new TeamResource($this->whenLoaded('school')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
