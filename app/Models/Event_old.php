<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'city',
        'country',
        'date',
        'time',
        'event_type',
        'event_url',
        'event_orgnizer_email',
        'event_orgnizer_phone',
        'image',
        'show_on_home_page',
        'redirect_advertizer_site',
    ];

    public function eventDetail()
    {
        return $this->hasMany(EventDetail::class, "event_id", "id");
    }
    public function eventImage()
    {
        return $this->hasOne(Media::class, 'id', 'image');
    }
}
