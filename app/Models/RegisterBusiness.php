<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterBusiness extends Model
{
    use HasFactory;

    protected $table = 'register_businesses';


    public function registerBusinessDetail()
    {
        return $this->hasMany(RegisterBusinessDetail::class, "register_business_id", "id");
    }
}
