<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function storyDetail()
    {
        return $this->hasMany(StoryDetail::class, "story_id", "id");
    }

    public function StoryImage()
    {
        return $this->hasOne(Media::class, 'id', 'image');
    }
}
