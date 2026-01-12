<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramDetail extends Model
{
    use HasFactory;

    protected $fillable = ["program_id", "language_id", "name", "description","customer_id"];
    public $timestamps = false;


    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
