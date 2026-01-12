<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerDetail extends Model
{
    use HasFactory;
    protected $fillable = ["career_id", "language_id", "level", "h_structure","code","class_name","class_definition"];
    protected $table = 'career_details';
    public $timestamps = false;


    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    






}
