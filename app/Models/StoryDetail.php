<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
