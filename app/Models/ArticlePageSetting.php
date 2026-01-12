<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticlePageSetting extends Model
{
    use HasFactory;

    public function articlePageSettingDetail()
    {
        return $this->hasMany(ArticlePageSettingDetail::class, "article_page_setting_id", "id");
    }
}
