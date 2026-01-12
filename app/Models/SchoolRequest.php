<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'website',
        'email',
        'phone',
        'time',
        'timezone',
        'province',
        'country',
        'description',
        'status'
    ];
}
