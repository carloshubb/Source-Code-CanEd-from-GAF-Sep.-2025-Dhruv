<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolTeamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'name' => $this->name,
            'designation' => $this->designation,
            'summary' => $this->summary,
            'phone' => $this->phone,
            'email' => $this->email,
            'image' => $this->image,
            'images' => explode(',', $this->image),
        ];
    }
}
