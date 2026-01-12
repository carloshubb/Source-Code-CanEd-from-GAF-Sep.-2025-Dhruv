<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolAmbassadorDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'school_ambassador_id' => $this->school_ambassador_id,
            'language_code' => $this->language_code,
            'name' => $this->name,
            'about_me' => $this->about_me,
        ];
    }
}
