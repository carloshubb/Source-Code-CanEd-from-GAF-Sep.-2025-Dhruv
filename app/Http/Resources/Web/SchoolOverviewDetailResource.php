<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolOverviewDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'blog_pre_description' => $this->blog_pre_description,
            'blog_post_description' => $this->blog_post_description,
            'programs_pre_description' => $this->programs_pre_description,
            'programs_post_description' => $this->programs_post_description,
            'language_code' => $this->language_code,
        ];
    }
}
