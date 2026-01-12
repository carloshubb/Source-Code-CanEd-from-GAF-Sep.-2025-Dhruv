<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'degree_id' => $this->degree_id ?? null,
            'status' => $this->status,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'program_detail' => ProgramDetailResource::collection($this->whenLoaded('programDetail')),
            'program_degree_level' => ProgramDegreeLevelResource::collection($this->whenLoaded('programDegreeLevel')),
        ];
    }
}
