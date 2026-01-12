<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class LeadershipSkillResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'leadership_skill_detail' => LeadershipSkillDetailResource::collection($this->whenLoaded('leadershipSkillDetail')),
        ];
    }
}
