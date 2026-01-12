<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamDetail extends Model
{
    use HasFactory;

    protected $fillable = ["team_id", "language_id","name","title","slug"];
    public $timestamps = false;


    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
