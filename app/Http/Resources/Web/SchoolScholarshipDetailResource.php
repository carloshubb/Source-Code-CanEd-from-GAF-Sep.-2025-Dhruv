<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolScholarshipDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'school_scholarship_id' => $this->school_scholarship_id,
            'language_code' => $this->language_code,
            'name' => $this->name,
            'summary' => $this->summary,
            'criteria' => $this->criteria,
        ];
    }
}
