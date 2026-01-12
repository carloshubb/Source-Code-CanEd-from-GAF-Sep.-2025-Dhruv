<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'image' => $this->image,
            'images' => explode(',', $this->image),
            'publised_at' => isset($this->publised_at) ? date('m/d/Y', strtotime($this->publised_at)) : null,
            'blog_detail' => isset($this->blogDetail) ? BlogDetailResource::collection($this->blogDetail) : null,
        ];
    }
}
