<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CareerSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'career_setting_id' => $this->career_setting_id,
            'language_id' => $this->language_id,
            'title' => $this->title,
            'description' => $this->description,
            'page_title' => $this->page_title,
            'article_title' => $this->article_title,
            'tab_1_title' => $this->tab_1_title,
            'tab_2_title' => $this->tab_2_title,
            'tab_3_title' => $this->tab_3_title,
            'search_input_placeholder' => $this->search_input_placeholder,
            'career_setting' => new DegreeResource($this->whenLoaded('career_setting')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
