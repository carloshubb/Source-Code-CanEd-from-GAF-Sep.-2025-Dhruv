<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramDegreeLevelResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'program_id' => $this->program_id,
            'degree_id' => $this->degree_id,
        ];
    }
}
