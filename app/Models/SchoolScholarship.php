<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolScholarship extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function schoolScholarshipDetail()
    {
        return $this->hasMany(SchoolScholarshipDetail::class);
    }
    public function school(){
        return $this->belongsTo(School::class);
    }
    public function favourite(){
        return $this->hasMany(Favourite::class,'record_id','id')->where('model','scholarship');
    }
}
