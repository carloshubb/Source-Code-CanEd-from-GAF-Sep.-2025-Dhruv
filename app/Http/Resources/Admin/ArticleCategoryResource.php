<?php

namespace App\Http\Resources\Admin;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'article_category_image' => new MediaResource($this->ArticleCategoryImage),
            'parent_id' => $this->parent_id,
            'child_categories' => $this->childCategories,
            'type' => $this->type,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'article_category_detail' => ArticleCategoryDetailResource::collection($this->whenLoaded('ArticleCategoryDetail')),
        ];
    }
}
