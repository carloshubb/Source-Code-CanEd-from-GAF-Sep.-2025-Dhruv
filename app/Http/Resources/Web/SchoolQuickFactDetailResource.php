<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolQuickFactDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'school_quick_fact_id' => $this->school_quick_fact_id,
            'language_code' => $this->language_code,
            'title_1' => $this->title_1,
            'title_1_paragraph' => $this->title_1_paragraph,
            'title_2' => $this->title_2,
            'title_2_subtitle' => $this->title_2_subtitle,
            'title_2_paragraph' => $this->title_2_paragraph,
            'title_2_button_title' => $this->title_2_button_title,
        ];
    }
}
