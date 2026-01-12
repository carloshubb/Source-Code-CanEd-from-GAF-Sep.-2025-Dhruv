<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitemapSetting extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sitemapSettingDetail()
    {
        return $this->hasMany(SitemapSettingDetail::class, "sitemap_setting_id", "id");
    }
}
