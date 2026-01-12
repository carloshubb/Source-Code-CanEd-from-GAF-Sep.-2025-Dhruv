<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProgram extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function schoolProgramDetail()
    {
        return $this->hasMany(SchoolProgramDetail::class);
    }

    public function schoolProgramDegreeLevel()
    {
        return $this->hasMany(SchoolProgramDegreeLevel::class, "school_program_id", "id");
    }

    public function Program()
    {
        return $this->belongsTo(Program::class)->with('programDetail');
    }

    public function School()
    {
        return $this->belongsTo(School::class)->with('SchoolDetail');
    }
}
