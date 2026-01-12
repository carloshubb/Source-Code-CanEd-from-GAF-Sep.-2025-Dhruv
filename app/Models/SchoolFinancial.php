<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolFinancial extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schoolFinancialDetail()
    {
        return $this->hasMany(SchoolFinancialDetail::class);
    }
}
