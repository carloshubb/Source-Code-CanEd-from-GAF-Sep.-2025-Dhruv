<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => new MediaResource($this->StoryImage),
            'student_name' => $this->student_name,
            'email' => $this->email,
            'country_of_origin' => $this->country_of_origin,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'story_detail' => StoryDetailResource::collection($this->whenLoaded('storyDetail')),
        ];
    }
}
