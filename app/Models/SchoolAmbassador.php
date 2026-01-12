<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SchoolAmbassador extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];

    public function schoolAmbassadorDetail()
    {
        return $this->hasMany(SchoolAmbassadorDetail::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    } 
    public function degree_detail()
    {
        return $this->belongsTo(DegreeDetail::class);
    }
     public function messagingApp()
    {
        return $this->hasMany(AmbssadorMessagingApp::class,'ambassadors_id','id');
    }
}
