<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'featured',
        'link',
        'show_on_home_page',
        'customer_id',
    ];

    public function videoDetail()
    {
        return $this->hasMany(VideoDetail::class, "video_id", "id");
    }
}
