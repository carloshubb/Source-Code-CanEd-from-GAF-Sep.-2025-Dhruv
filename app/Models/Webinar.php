<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_ambassador_id',
        'title',
        'start_date',
        'timezone',
        'live_strom_webinar',
        'image'
    ];

    public function webinarDetail()
    {
        return $this->hasMany(WebinarDetail::class, "webinar_id", "id");
    }
    public function webinarParticepent()
    {
        return $this->hasMany(WebinarParticepent::class, "webinar_id", "id");
    }

    public function schoolAmbassador()
    {
        return $this->belongsTo(SchoolAmbassador::class);
    }

    
}
