<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolOverViewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'customer_id' => $this->customer_id ?? null,
            'display_blog' => $this->display_blog ?? null,
            'school_overviews_apply_button_link' => $this->school_overviews_apply_button_link ?? null,
            'school_overviews_apply_button_title' => $this->school_overviews_apply_button_title ?? null,
            'school_overviews_red_bar_button_link' => $this->school_overviews_red_bar_button_link ?? null,
            'school_overviews_red_bar_button_title' => $this->school_overviews_red_bar_button_title ?? null,
            'school_overviews_blue_bar_button_link' => $this->school_overviews_blue_bar_button_link ?? null,
            'school_overviews_blue_bar_button_title' => $this->school_overviews_blue_bar_button_title ?? null,
            'number_of_blog_posts' => $this->number_of_blog_posts ?? null,
            'blog_posts_order' => $this->blog_posts_order ?? null,
            'video_url' => $this->video_url ?? null,
            'video_iframe' => $this->video_iframe ?? null,
            'created_at' => isset($this->created_at) ? date('m/d/Y H:i:s', strtotime($this->created_at)) : null,
            'school_overview_detail' => isset($this->schoolOverviewDetail) ? SchoolOverviewDetailResource::collection($this->schoolOverviewDetail) : null,
        ];
    }
}
