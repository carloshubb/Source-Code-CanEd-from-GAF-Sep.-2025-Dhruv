<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadershipSkill extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    public function leadershipSkillDetail()
    {
        return $this->hasMany(LeadershipSkillDetail::class, 'leadership_skill_id', 'id');
    }
}
