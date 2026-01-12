<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolQuickFactsFeature extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function schoolQuickFactDetail()
    {
        return $this->hasMany(SchoolQuickFactDetail::class);
    }

    public function schoolQuickFact()
    {
        return $this->belongsTo(SchoolQuickFact::class);
    }
}
