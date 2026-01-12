<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_code',
        'banner_type',
        'banner_button_link',
        'banner_image',
        'banner_image_2'
    ];

    public function BannerDetail()
    {
        return $this->hasMany(BannerDetail::class, "banner_id", "id");
    }
    public function Image1()
    {
        return $this->hasOne(Media::class, 'id', 'banner_image');
    }

    public function Image2()
    {
        return $this->hasOne(Media::class, 'id', 'banner_image_2');
    }
}
