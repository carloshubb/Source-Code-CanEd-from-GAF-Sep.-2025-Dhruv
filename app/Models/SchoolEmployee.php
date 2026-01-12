<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolEmployee extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function schoolEmployeeDetail()
    {
        return $this->hasMany(SchoolEmployeeDetail::class);
    }
}
