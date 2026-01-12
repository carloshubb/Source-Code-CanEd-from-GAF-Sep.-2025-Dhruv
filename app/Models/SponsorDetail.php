<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "sponsor_id", "language_id", "title", "slug",
        'subsidiary',
        'keywords',
        'contact_person_name',
        'short_description',
        'description',
        'service1_name',
        'service1_url',
        'service2_name',
        'service2_url',
        'service3_name',
        'service3_url',
        'service4_name',
        'service4_url',
        'service5_name',
        'service5_url'
    ];
    public $timestamps = false;


    public function sponsor()
    {
        return $this->belongsTo(Event::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
