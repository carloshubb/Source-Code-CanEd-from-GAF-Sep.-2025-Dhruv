<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\ProgramResource;
use App\Http\Resources\Admin\SchoolProgramDegreeLevelResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolProgramResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'school_program_degree_level' => SchoolProgramDegreeLevelResource::collection($this->whenLoaded('schoolProgramDegreeLevel')),
            'program' => new ProgramResource($this->Program),
            'program_id' => $this->program_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'school_program_detail' => SchoolProgramDetailResource::collection($this->whenLoaded('SchoolProgramDetail')),
            'program' => new SchoolProgramDetailResource($this->whenLoaded('Program')),
        ];
    }
}
