<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $fillable = ['hot'];

    public function careerDetail()
    {
        return $this->hasMany(CareerDetail::class, "career_id", "id");
    }
}
