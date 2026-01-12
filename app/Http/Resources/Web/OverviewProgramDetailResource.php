<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class OverviewProgramDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'overview_program_id' => $this->overview_program_id,
            'language_code' => $this->language_code,
            'name' => $this->name,
        ];
    }
}
