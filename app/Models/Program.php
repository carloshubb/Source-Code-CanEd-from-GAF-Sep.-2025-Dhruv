<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = ['degree_id', 'customer_id', 'status'];

    public function programDetail()
    {
        return $this->hasMany(ProgramDetail::class, "program_id", "id");
    }

    public function programDegreeLevel()
    {
        return $this->hasMany(ProgramDegreeLevel::class, "program_id", "id");
    }

    public function Degree()
    {
        return $this->hasOne(Degree::class, 'id', 'degree_id');
    }

    public function SchoolPrograms()
    {
        return $this->hasMany(SchoolProgram::class, 'program_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
