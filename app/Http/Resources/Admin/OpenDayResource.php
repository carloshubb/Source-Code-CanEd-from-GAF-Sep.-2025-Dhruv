<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Web\OpenDayDetailResource;
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
            'school_id'=>$this->school_id,
            'open_day_url' => $this->open_day_url,
            'postal_code' => $this->postal_code,
            'image' => $this->image,
            'status' => $this->status,
            'school' => new SchoolResource($this->whenLoaded('school')),
            'OpenDayDetail' => OpenDayDetailResource::collection($this->whenLoaded('OpenDayDetail')),
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
        ];
    }
}
