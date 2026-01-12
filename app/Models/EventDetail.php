<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'language_id', 'title', 'description', 'short_description', 'slug'];
    public $timestamps = false;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
