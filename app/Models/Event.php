<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_date',
        'location',
        'end_date',
        'event_website',
        'exibiters_url',
        'visitor_url',
        'press_url',
        'video_url',
        'video_frame',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'pintrest_url',
        'snapchat_url', 
        'twitter_url', 
        'featured_image', 
        'status', 
        'customer_id',
        'school_id',
        'city', 
        'country', 
        'street_name', 
        'veneue', 
        'product_search',
        'state_province',
        'slug',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function eventDetail()
    {
        return $this->hasMany(EventDetail::class, 'event_id', 'id');
    }

    public function eventContact()
    {
        return $this->hasMany(EventContact::class, 'event_id', 'id');
    }

    public function eventImage()
    {
        return $this->hasOne(Media::class, 'id', 'featured_image');
    }

    public function eventImages()
    {
        return $this->hasMany(EventImage::class, 'event_id', 'id');
    }

    public function favourite()
    {
        return $this->hasMany(Favourite::class, 'record_id', 'id')->where('model', 'event');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
