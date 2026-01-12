<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'program_setting_id' => $this->program_setting_id,
            'language_id' => $this->language_id,
            'description' => $this->description,
            'page_title' => $this->page_title,
            'button_text' => $this->button_text,
            'program_setting' => new DegreeResource($this->whenLoaded('program_setting')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
