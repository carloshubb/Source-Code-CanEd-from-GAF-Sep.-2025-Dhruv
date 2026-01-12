<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SponsorDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sponsor_id' => $this->sponsor_id,
            'language_id' => $this->language_id,
            'title' => $this->title,
            'subsidiary' => $this->subsidiary,
            'keywords' => $this->keywords,
            'contact_person_name' => $this->contact_person_name,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'service1_name' => $this->service1_name,
            'service1_url' => $this->service1_url,
            'service2_name' => $this->service2_name,
            'service2_url' => $this->service2_url,
            'service3_name' => $this->service3_name,
            'service3_url' => $this->service3_url,
            'service4_name' => $this->service4_name,
            'service4_url' => $this->service4_url,
            'service5_name' => $this->service5_name,
            'service5_url' => $this->service5_url,
            'sponsor' => new SponsorResource($this->whenLoaded('sponsor')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
