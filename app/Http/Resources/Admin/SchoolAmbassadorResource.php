<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolAmbassadorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'region' => $this->region,
            'title' => $this->title,
            'image' => $this->image,
            'langs' => $this->langs,
            'degree_level' => $this->degree_level,
            'fav_module' => $this->fav_module,
            'I_study_here' => $this->I_study_here,
            'hobies_interests' => $this->hobies_interests,
            'societies' => $this->societies,
            'category' => $this->category,
            'email' => $this->email,
            'school_id' => $this->school_id,
            'whats_app_number' => $this->whats_app_number,
            'skype_id' => $this->skype_id ,
            'we_chat_number' => $this->we_chat_number,
            'viber_number' =>$this->viber_number,
            'imo_number' =>$this->imo_number,
            'mobile_number' => $this->mobile_number,
            'message_number' => $this->message_number,
            'my_major' => $this->my_major,
            'my_minor' => $this->my_minor,
            'status' => $this->status,
            'school_ambassador_detail' => SchoolAmbassadorDetailResource::collection($this->whenLoaded('schoolAmbassadorDetail')),
            'messaging_app' => AmbassadorMessagingAppResource::collection($this->whenLoaded('messagingApp')),

        ];
    }
}
