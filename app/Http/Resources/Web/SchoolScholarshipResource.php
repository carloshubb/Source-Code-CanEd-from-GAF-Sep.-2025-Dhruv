<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\DegreeResource;
use App\Http\Resources\Admin\ProgramResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolScholarshipResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'province' => $this->province,
            'award' => $this->award,
            'amount' => $this->amount,
            'action' => $this->action,
            'date_posted' => $this->date_posted,
            'expiry_date' => $this->expiry_date,
            'deadline_date' => $this->deadline_date,
            'availability' => $this->availability,
            'study_level' => $this->study_level,
            'duration' => $this->duration,
            'link' => $this->link,
            'more_info_link' => $this->more_info_link,
            'featured' => $this->featured,
            'image' => $this->image,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'school_scholarship_detail' => SchoolScholarshipDetailResource::collection($this->whenLoaded('schoolScholarshipDetail')),
        ];
    }
}
