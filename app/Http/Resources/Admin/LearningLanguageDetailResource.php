<?php

namespace App\Http\Resources\Admin;

use App\Models\LearningLanguage;
use Illuminate\Http\Resources\Json\JsonResource;

class LearningLanguageDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'learning_language_id' => $this->learning_language_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'learning_language' => new LearningLanguageResource($this->whenLoaded('learningLanguage')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
