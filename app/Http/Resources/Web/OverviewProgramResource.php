<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class OverviewProgramResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'length' => $this->length,
            'tuition_inter_stu_fee' => $this->tuition_inter_stu_fee,
            'tuition_can_stu_fee' => $this->tuition_can_stu_fee,
            'tuition_prov_stu_fee' => $this->tuition_prov_stu_fee,
            'school_overviews_id' => $this->school_overviews_id,
            'overview_program_detail' => OverviewProgramDetailResource::collection($this->whenLoaded('overviewProgramDetail')),
        ];
    }
}
