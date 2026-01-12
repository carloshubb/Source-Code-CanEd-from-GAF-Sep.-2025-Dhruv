<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class NetworkResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => new MediaResource($this->networkImage),
            'status' => $this->status,
            'banner_location' => $this->banner_location,
            'state_province' => $this->state_province,

            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'country' => $this->country,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'network_detail' => NetworkDetailResource::collection($this->whenLoaded('networkDetail')),
        ];
    }
}
