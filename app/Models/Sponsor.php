<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'image',
        'url',
        'status',
        'contact_person_phone',
        'contact_person_image',
        'contact_person_email',
    ];

    public function sponsorDetail()
    {
        return $this->hasMany(SponsorDetail::class, "sponsor_id", "id");
    }
    public function sponsorImage()
    {
        return $this->hasOne(Media::class, 'id', 'image');
    }
}
