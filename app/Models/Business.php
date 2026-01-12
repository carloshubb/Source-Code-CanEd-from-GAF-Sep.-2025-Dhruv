<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = [];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function registrationPackage()
    {
        return $this->belongsTo(RegistrationPackage::class);
    }
    public function businessDetail(){
        return $this->hasMany(BusinessDetail::class);
    }

    public function businessCategory1()
    {
        return $this->belongsTo(BusinessCategory::class,'business_catagory_1','id');
    }

    public function businessCategory2()
    {
        return $this->belongsTo(BusinessCategory::class,'business_catagory_2','id');
    }

    public function businessCategory3()
    {
        return $this->belongsTo(BusinessCategory::class,'business_catagory_3','id');
    }

    public function favourite(){
        return $this->hasMany(Favourite::class,'record_id','id')->where('model','business');
    }
  
}
