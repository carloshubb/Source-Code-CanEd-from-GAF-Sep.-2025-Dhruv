<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'template' => $this->template,
            'image' => $this->image,
            'slug' => $this->slug,
            'set_as_home' => $this->set_as_home,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'page_detail' => PageDetailResource::collection($this->whenLoaded('PageDetail')),
        ];
    }
}
