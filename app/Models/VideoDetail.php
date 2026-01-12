<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoDetail extends Model
{
    use HasFactory;
    protected $fillable = ["video_id", "language_id","description","title","slug"];
    public $timestamps = false;


    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
