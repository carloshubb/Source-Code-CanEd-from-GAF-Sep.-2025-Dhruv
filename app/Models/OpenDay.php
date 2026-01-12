<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'school_id',
        'address',
        'city',
        'postal_code',
        'country',
        'time',
        'date',
        'school_email',
        'school_phone',
        'open_day_url',
        'image',
        'status'
    ];

    public function openDayDetail()
    {
        return $this->hasMany(OpenDayDetail::class, "open_day_id", "id");
    }

    public function school()
    {
        return $this->belongsTo(School::class,'school_id','id');
    }

    public function favourite(){
        return $this->hasMany(Favourite::class,'record_id','id')->where('model','openday');
    }
}
