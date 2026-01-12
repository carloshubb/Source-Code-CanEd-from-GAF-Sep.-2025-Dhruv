<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class OpenDayResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'date' => $this->date,
            'time' => $this->time,
            'school_email' => $this->school_email,
            'school_phone' => $this->school_phone,
            'open_day_url' => $this->open_day_url,
            'postal_code' => $this->postal_code,
            'image' => $this->image,
            'open_day_detail' => OpenDayDetailResource::collection($this->whenLoaded('openDayDetail')),
        ];
    }
}
