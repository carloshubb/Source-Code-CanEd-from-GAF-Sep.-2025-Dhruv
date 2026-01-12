<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class WebinarDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'webinar_id' => $this->webinar_id,
            'language_code' => $this->language_code,
            'topic' => $this->topic,
            'agenda' => $this->agenda,
        ];
    }
}
