<?php

namespace App\Http\Resources\Admin;

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
            'time_zone' => $this->time_zone,
            'province' => $this->province,
            'youtube_link' => $this->youtube_link,
            'country' => $this->country,
            'city' => $this->city,
            'degree_id' => $this->degree_id,
            'image'  => $this->image,
            'deactive_account'  => $this->deactive_account,
            'master_application' => count($this->masterApplications),
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'master_app_threshold' => $this->master_app_threshold,
            'school_detail' => SchoolDetailResource::collection($this->whenLoaded('schoolDetail')),
            'other_button_link' => $this->other_button_link,
            'quick_facts_status' => $this->quick_facts_status,
            'overview_status' => $this->overview_status,
            'program_status' => $this->program_status,
            'admission_status' => $this->admission_status,
            'financial_status' => $this->financial_status,
            'scholarship_status' => $this->scholarship_status,
            'contacts_status' => $this->contacts_status,
            'ambassador_status' => $this->ambassador_status,
            // remaining
            'main_button_link' => $this->main_button_link,
            'facebook' => $this->facebook,
            'linkedin' => $this->linkedin,
            'insta' => $this->insta,
            'twitter' => $this->twitter,
            'youtube' => $this->youtube,
            'vk' => $this->vk,
            'school_more_images' => $this->schoolMoreImages,
            'school_more_links' => $this->schoolMoreLinks,
        ];
    }
}
