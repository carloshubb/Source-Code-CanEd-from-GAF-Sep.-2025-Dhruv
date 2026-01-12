<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticlePageSettingDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'article_page_setting_id' => $this->article_page_setting_id,
            'language_id' => $this->language_id,
            'page_title' => $this->page_title,
            'search_placeholder' => $this->search_placeholder,
            'article_page_setting' => new ArticlePageSettingResource($this->whenLoaded('articlePageSetting')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
