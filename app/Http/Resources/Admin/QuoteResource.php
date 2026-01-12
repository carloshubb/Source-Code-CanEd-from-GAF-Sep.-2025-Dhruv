<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'name' => $this->name,
            'location' => $this->location,
            'user_id' => $this->user_id,
            'user' => $this->user,
            'quote_image' => new MediaResource($this->QuoteImage),
            'school' => new SchoolResource($this->school),
            'school_id' => $this->school_id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'quote_detail' => QuoteDetailResource::collection($this->whenLoaded('quoteDetail')),
        ];
    }
}
