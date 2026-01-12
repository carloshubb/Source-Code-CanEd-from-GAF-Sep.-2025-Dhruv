<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'school_id' => $this->school_id,
            'language_code' => $this->language_code,
            'description' => $this->description,
            'school_name' => $this->school_name,
            'more_button_title' => $this->more_button_title,
            'more_button_sub_title' => $this->more_button_sub_title,
            'other_button_title' => $this->other_button_title,
        ];
    }
}
