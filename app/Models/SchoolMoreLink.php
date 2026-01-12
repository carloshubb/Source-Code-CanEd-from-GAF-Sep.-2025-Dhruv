<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolMoreLink extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schoolMoreLinkDetail()
    {
        return $this->hasMany(SchoolMoreLinkDetail::class);
    }
}
