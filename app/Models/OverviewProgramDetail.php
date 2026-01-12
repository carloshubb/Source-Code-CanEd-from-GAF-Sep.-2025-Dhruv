<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverviewProgramDetail extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'language_code', 'overview_program_id'];
}
