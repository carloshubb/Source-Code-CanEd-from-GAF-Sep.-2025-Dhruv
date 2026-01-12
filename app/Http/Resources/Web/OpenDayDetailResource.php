<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class OpenDayDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'open_day_id' => $this->open_day_id,
            'language_code' => $this->language_code,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
