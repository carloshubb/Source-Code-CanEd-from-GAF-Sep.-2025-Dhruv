<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolProgramDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'school_program_id' => $this->school_program_id,
            'language_code' => $this->language_code,
            'description' => $this->description,
        ];
    }
}
