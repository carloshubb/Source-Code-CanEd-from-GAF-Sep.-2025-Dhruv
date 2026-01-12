<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticlePageSettingDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function articlePageSetting()
    {
        return $this->belongsTo(ArticlePageSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
