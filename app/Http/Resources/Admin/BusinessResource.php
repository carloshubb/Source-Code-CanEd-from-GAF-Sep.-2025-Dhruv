<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'facebook_url' => $this->facebook_url,
            'welcome_video' => $this->welcome_video,
            'twitter_url' => $this->twitter_url,
            'youtube_url' => $this->youtube_url,
            'linked_url' => $this->linked_url,
            'other_social_url' => $this->other_social_url,
            'image' => $this->image,
            'keywords' => $this->keywords,
            'images' => explode(',', $this->image),
            'contact_name' => $this->contact_name,
            'email' => $this->email,
            'logo' => $this->logo,
            'phone' => $this->phone,
            'address' => $this->address,
            'website_url'  => $this->website_url,
            'business_catagory_1'  => $this->business_catagory_1,
            'business_catagory_2'  => $this->business_catagory_2,
            'business_catagory_3'  => $this->business_catagory_3,
            'deactive_account'  => $this->deactive_account,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'business_detail' => BusinessDetailResource::collection($this->whenLoaded('businessDetail')),
        ];
    }
}
