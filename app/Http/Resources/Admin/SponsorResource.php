<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SponsorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => new MediaResource($this->sponsorImage),
            'country' => $this->country,
            'url' => $this->url,
            'status' => $this->status,
            'contact_person_phone' => $this->contact_person_phone,
            'contact_person_image' => $this->contact_person_image,
            'contact_person_email' => $this->contact_person_email,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'sponsor_detail' => SponsorDetailResource::collection($this->whenLoaded('sponsorDetail')),
        ];
    }
}
