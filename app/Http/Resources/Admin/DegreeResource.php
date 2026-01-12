<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DegreeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'degree_name' =>  $this->degreeDetail->first()->name ?? null,
            'degree_image' => new MediaResource($this->DegreeImage),
            'image' => $this->image ?? null,
            'order' => $this->order,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'degree_detail' => DegreeDetailResource::collection($this->whenLoaded('degreeDetail')),
        ];
    }
}
