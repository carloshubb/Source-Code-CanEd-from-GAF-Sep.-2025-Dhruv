<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'school_id', 'article_image', 'original_source', 'name_title', 'organization', 'website', 'article_category', 'created_by', 'updated_by', 'keyword'];

    public function articleCategory()
    {
        return $this->belongsTo(ArticleCategory::class, 'article_category', 'id');
    }

    public function articleDetail()
    {
        return $this->hasMany(ArticleDetail::class, "article_id", "id");
    }
    public function ArticleImage()
    {
        return $this->hasOne(Media::class, 'id', 'article_image');
    }

    public function createdByUser()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function createdByCustomer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function updatedByUser()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }


    public function getCreatedAtAttribute($value)
    {
        return date('d M Y', strtotime($value));
    }

    public function favourite()
    {
        return $this->hasMany(Favourite::class, 'record_id', 'id')->where('model', 'article');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
