<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order' => $this->order,
            'type' => $this->type,
            'customer_id' => $this->customer_id,
            'faq_detail' => FaqDetailResource::collection($this->whenLoaded('FaqDetail')),
        ];
    }
}
