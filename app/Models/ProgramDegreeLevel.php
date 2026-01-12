<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramDegreeLevel extends Model
{
    use HasFactory;

    protected $fillable = ["program_id", "degree_id"];
    public $timestamps = false;


    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }
}
