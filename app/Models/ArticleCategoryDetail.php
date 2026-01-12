<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategoryDetail extends Model
{
    use HasFactory;
    protected $fillable = ["article_category_id", "language_id", "name", "slug"];
    protected $table = 'article_category_details';
    public $timestamps = false;


    public function article_category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
