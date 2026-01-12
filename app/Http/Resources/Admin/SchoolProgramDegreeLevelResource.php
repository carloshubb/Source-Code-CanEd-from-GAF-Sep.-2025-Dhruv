<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolProgramDegreeLevelResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'school_program_id' => $this->school_program_id,
            'degree' => new DegreeResource($this->Degree),
        ];
    }
}
