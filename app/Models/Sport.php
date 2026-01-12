<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;
    protected $fillable = ['status'];

    public function sportDetail()
    {
        return $this->hasMany(SportDetail::class, 'sport_id', 'id');
    }
}
