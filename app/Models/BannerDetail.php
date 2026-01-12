<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        "banner_id",
        "language_id",
        "title",
        "banner_description",
        "banner_button_text"
    ];

    public $timestamps = false;


    public function banner()
    {
        return $this->belongsTo(Banner::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
