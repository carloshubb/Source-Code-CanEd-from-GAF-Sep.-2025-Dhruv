<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'faq_id' => $this->faq_id,
            'language_code' => $this->language_code,
            'question' => $this->question,
            'answer' => $this->answer,
        ];
    }
}
