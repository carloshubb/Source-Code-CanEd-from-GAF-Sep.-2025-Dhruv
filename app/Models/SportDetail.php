<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportDetail extends Model
{
    use HasFactory;

    protected $fillable = ["sport_id", "language_id", "name"];
    public $timestamps = false;
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
