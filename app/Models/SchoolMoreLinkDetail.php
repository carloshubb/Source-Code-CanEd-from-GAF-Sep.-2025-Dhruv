<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolMoreLinkDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schoolMoreLink()
    {
        return $this->hasMany(SchoolMoreLink::class);
    }
}
