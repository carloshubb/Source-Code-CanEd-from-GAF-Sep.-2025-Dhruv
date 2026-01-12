<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadershipSkillDetail extends Model
{
    use HasFactory;

    protected $fillable = ["leadership_skill_id", "language_id", "name"];
    
    public $timestamps = false;

    public function leadershipSkill()
    {
        return $this->belongsTo(LeadershipSkill::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
