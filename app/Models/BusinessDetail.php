<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bussiness(){
        return $this->belongsTo(Business::class);
    }

    public function language(){
        return $this->belongsTo(Language::class);
    }

}
