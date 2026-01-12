<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CurricularActivityDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'curricular_id' => $this->curricular_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'curricular_activity' => new CurricularActivityResource($this->whenLoaded('curricularActivity')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
