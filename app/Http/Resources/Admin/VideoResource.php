<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'featured' => $this->featured,
            'link' => $this->link,
            'show_on_home_page' => $this->show_on_home_page,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'video_detail' => VideoDetailResource::collection($this->whenLoaded('videoDetail')),
        ];
    }
}
