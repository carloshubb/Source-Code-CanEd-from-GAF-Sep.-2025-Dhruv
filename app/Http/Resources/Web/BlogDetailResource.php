<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'blog_id' => $this->blog_id,
            'language_id' => $this->language_id,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'detail_description' => $this->detail_description,
            'category_name' => $this->category_name,
        ];
    }
}
