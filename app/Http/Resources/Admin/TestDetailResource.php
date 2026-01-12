<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class TestDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'test_id' => $this->test_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'test' => new TestResource($this->whenLoaded('test')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
