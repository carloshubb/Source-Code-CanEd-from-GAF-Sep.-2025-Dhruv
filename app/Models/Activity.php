<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'status'];

    // Define all possible types as constants
    const TYPE_CURRICULAR = 'curricular';
    const TYPE_EXTRACURRICULAR = 'extracurricular';
    const TYPE_LEADERSHIP = 'leadership';
    const TYPE_MEDIA = 'media';
    const TYPE_MUSIC = 'music_performance';
    const TYPE_SOCIAL = 'social_activism';
    const TYPE_TECHNOLOGY = 'technology';
    const TYPE_ENTREPRENEURSHIP = 'entrepreneurship';
    const TYPE_ENVIRONMENTAL = 'environmental';
    const TYPE_STEM = 'stem_competitions';
    const TYPE_HEALTH = 'health_wellness';
    // Add all other types here...

    public static function getTypes()
    {
        return [
            self::TYPE_CURRICULAR => 'Curricular Activities',
            self::TYPE_EXTRACURRICULAR => 'Extracurricular Activities',
            self::TYPE_LEADERSHIP => 'Leadership',
            self::TYPE_MEDIA => 'Media',
            self::TYPE_MUSIC => 'Music & Performance',
            self::TYPE_SOCIAL => 'Social Activism',
            self::TYPE_TECHNOLOGY => 'Technology',
            self::TYPE_ENTREPRENEURSHIP => 'Entrepreneurship',
            self::TYPE_ENVIRONMENTAL => 'Environmental & Sustainability',
            self::TYPE_STEM => 'STEM competitions',
            self::TYPE_HEALTH => 'Health & Wellness',
            // Add all other types here...
        ];
    }

    public function details()
    {
        return $this->hasMany(ActivityDetail::class);
    }

    public function demetraActivities()
    {
        return $this->hasMany(SchoolDemetraSetting::class, 'activity_id');
    }
}