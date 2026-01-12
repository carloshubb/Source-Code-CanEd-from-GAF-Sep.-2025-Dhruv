<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticlePageSettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'article_page_setting_detail' => ArticlePageSettingDetailResource::collection($this->whenLoaded('articlePageSettingDetail')),
        ];
    }
}
