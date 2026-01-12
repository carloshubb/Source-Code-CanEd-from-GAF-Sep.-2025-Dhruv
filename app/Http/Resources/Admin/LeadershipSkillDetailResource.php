<?php

namespace App\Http\Resources\Admin;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadershipSkillDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'leadership_skill_id' => $this->leadership_skill_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'leadership_skill' => new LeadershipSkillResource($this->whenLoaded('leadershipSkill')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
