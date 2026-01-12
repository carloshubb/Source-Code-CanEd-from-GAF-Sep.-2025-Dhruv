<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CareerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'hot' => $this->hot,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'career_detail' => CareerDetailResource::collection($this->whenLoaded('careerDetail')),
        ];
    }
}
