<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolQuickFact extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function schoolQuickFactDetail()
    {
        return $this->hasMany(SchoolQuickFactDetail::class);
    }

    public function schoolQuickFactsFeature()
    {
        return $this->hasMany(SchoolQuickFactsFeature::class);
    }
}
