<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class HomePageSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'banner_1' => $this->banner_1,
            'banner_2' => $this->banner_2,
            'banner_3' => $this->banner_3,
            'article_section_1_category_id' => $this->article_section_1_category_id,
            'article_section_2_category_id' => $this->article_section_2_category_id,
            'article_section_3_category_id' => $this->article_section_3_category_id,
            'home_page_setting_detail' => HomePageSettingDetailResource::collection($this->whenLoaded('homePageSettingDetail')),
        ];
    }
}
