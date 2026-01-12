<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    use HasFactory;

    protected $fillable = ['article_category_image',"parent_id","type"];

    public function ArticleCategoryDetail()
    {
        return $this->hasMany(ArticleCategoryDetail::class, "article_category_id", "id");
    }
    public function ArticleCategoryImage()
    {
        return $this->hasOne(Media::class, 'id', 'article_category_image');
    }


    public function childCategories()
    {
        return $this->hasMany(ArticleCategory::class, 'parent_id', 'id');
    }

    public function articles(){
        return $this->hasMany(Article::class,'article_category','id');
    }
}
