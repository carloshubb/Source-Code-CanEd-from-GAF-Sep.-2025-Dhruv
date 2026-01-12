<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolContactDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'school_contact_id' => $this->school_contact_id,
            'language_code' => $this->language_code,
            'name' => $this->name,
            'brief_descr' => $this->brief_descr
        ];
    }
}
