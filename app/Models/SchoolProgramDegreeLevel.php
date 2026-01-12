<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProgramDegreeLevel extends Model
{
    use HasFactory;

    protected $fillable = ["school_program_id", "degree_id"];
    public $timestamps = false;


    public function school_program()
    {
        return $this->belongsTo(SchoolProgram::class);
    }

    public function Degree()
    {
        return $this->belongsTo(Degree::class)->with('degreeDetail');
    }
}
