<?php

namespace App\Http\Resources\Admin;

use App\Models\Activity;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'type_name' => Activity::getTypes()[$this->type] ?? $this->type,
            'status' => $this->status,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'details' => ActivityDetailResource::collection($this->whenLoaded('details')),
        ];
    }
}