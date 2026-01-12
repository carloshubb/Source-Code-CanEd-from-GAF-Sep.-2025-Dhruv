<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'article_category_id'=>$this->article_category,
            'type' => $this->articleCategory ? $this->articleCategory->type : null,
            'original_source'=>$this->original_source,            
            // 'customer_id,'=>$this->customer_id,            
            'name_title'=>$this->name_title,            
            'organization'=>$this->organization,
            'keyword' => $this->keyword,            
            'website'=>$this->website,            
            'article_image' => new MediaResource($this->ArticleImage),
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'article_detail' => ArticleDetailResource::collection($this->whenLoaded('articleDetail')),
        ];
    }
}
