<?php

namespace App\Http\Resources\Admin;
use Illuminate\Http\Resources\Json\JsonResource;

class ComunityServiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'comunity_service_detail' => ComunityServiceDetailResource::collection($this->whenLoaded('comunityServiceDetail')),
        ];
    }
}
