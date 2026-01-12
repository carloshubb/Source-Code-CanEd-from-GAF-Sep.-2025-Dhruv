<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'status',
    ];

    public function teamDetail()
    {
        return $this->hasMany(TeamDetail::class, "team_id", "id");
    }
    public function teamImage()
    {
        return $this->hasOne(Media::class, 'id', 'image');
    }
}
