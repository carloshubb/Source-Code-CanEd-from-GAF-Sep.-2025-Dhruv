<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualTour extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'deadline_date' => 'date',  // Treat deadline_date as a date
    ];

    public function school()
    {
        return $this->belongsTo(School::class,'school_id','id')->with('schoolDetail');
    }

    public function virtualTourDetail(){
        return $this->hasMany(VirtualTourDetail::class);
    }
}
