<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleCategoryDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'article_category_id' => $this->article_category_id,
            'language_id' => $this->language_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'article' => new ArticleCategoryResource($this->whenLoaded('article_category')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
