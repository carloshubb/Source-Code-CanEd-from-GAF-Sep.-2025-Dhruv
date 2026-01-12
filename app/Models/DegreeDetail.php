<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DegreeDetail extends Model
{
    use HasFactory;
    protected $fillable = ["degree_id", "language_id", "name", "slug"];
    protected $table = 'degree_details';
    public $timestamps = false;


    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
