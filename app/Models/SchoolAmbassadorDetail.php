<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolAmbassadorDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schoolAmbassador()
    {
        return $this->hasMany(SchoolAmbassador::class);
    }
}
