<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class QuoteDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'quote_id' => $this->quote_id,
            'language_id' => $this->language_id,
            'quote' => $this->quote,
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
