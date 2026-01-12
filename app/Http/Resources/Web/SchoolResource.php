<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\DegreeResource;
use App\Http\Resources\Admin\ProgramResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'website_url' => $this->website_url,
            'email' => $this->email,
            'phone' => $this->phone,
            'time' => $this->time,
            // 'degree_id' => $this->degree_id,
            'time_zone' => $this->time_zone,
            'province' => $this->province,
            'country'  => $this->country,
            'image'  => $this->image,
            'facebook' => $this->facebook,
            'linkedin' => $this->linkedin,
            'insta' => $this->insta,
            'twitter' => $this->twitter,
            'youtube' => $this->youtube,
            'vk' => $this->vk,
            'main_button_link' => $this->main_button_link,
            'other_button_link' => $this->other_button_link,
            'youtube_link' => $this->youtube_link,
            'youtube_iframe' => $this->youtube_iframe,
            'quick_facts_status' => $this->quick_facts_status,
            'overview_status' => $this->overview_status,
            'program_status' => $this->program_status,
            'admission_status' => $this->admission_status,
            'financial_status' => $this->financial_status,
            'scholarship_status' => $this->scholarship_status,
            'contacts_status' => $this->contacts_status,
            'ambassador_status' => $this->ambassador_status,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'school_detail' => SchoolDetailResource::collection($this->whenLoaded('schoolDetail')),
            'school_more_images' => $this->schoolMoreImages,
            'school_more_links' => $this->schoolMoreLinks,
        ];
    }
}
