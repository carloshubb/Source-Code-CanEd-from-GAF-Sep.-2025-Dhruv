<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'featured_image' => new MediaResource($this->eventImage),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'event_website' => $this->event_website,
            'exibiters_url' => $this->exibiters_url,
            'visitor_url' => $this->visitor_url,
            'press_url' => $this->press_url,
            'video_url' => $this->video_url,
            'video_frame' => $this->video_frame,
            'state_province' => $this->state_province,
            'location' => $this->location,
            'city' => $this->city,
            'country' => $this->country,
            'street_name' => $this->street_name,
            'veneue' => $this->veneue,
            'product_search' => $this->product_search,
            'facebook_url' => $this->facebook_url,
            'instagram_url' => $this->instagram_url,
            'linkedin_url' => $this->linkedin_url,
            'youtube_url' => $this->youtube_url,
            'pintrest_url' => $this->pintrest_url,
            'snapchat_url' => $this->snapchat_url,
            'twitter_url' => $this->twitter_url,
            'status' => $this->status,
            'event_images' => $this->eventImages,
            'slug' => $this->slug,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'event_detail' => EventDetailResource::collection($this->whenLoaded('eventDetail')),
            'contacts' => $this->eventContact,
        ];
    }
}
