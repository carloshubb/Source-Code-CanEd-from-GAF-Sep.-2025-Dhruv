<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitemapSettingDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function sitemapSetting()
    {
        return $this->belongsTo(SitemapSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
