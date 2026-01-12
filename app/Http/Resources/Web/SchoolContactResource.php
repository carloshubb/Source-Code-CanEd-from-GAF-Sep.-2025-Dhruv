<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolContactResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'department' => $this->department,
            'address' => $this->address,
            'direct_email' => $this->direct_email,
            'contact_linkedin' => $this->contact_linkedin,
            'contact_instagram' => $this->contact_instagram,
            'contact_facebook' => $this->contact_facebook,
            'city' => $this->city,
            'country' => $this->country,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'website_link' => $this->website_link,
            'order' => $this->order,
            'image' => $this->image,
            'school_contact_detail' => SchoolContactDetailResource::collection($this->whenLoaded('schoolContactDetail')),
        ];
    }
}
