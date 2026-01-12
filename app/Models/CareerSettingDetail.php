<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerSettingDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        "career_setting_id",
        "language_id",
        "title",
        "description",
        'page_title',
        'article_title',
        'tab_1_title',
        'tab_2_title',
        'tab_3_title',
        'search_input_placeholder'
    ];
    public $timestamps = false;


    public function career_setting()
    {
        return $this->belongsTo(CareerSetting::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
