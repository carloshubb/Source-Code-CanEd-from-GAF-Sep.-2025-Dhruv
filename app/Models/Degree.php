<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    use HasFactory;
    protected $fillable = ['degree_image','image','order','url'];

    public function degreeDetail()
    {
        return $this->hasMany(DegreeDetail::class, "degree_id", "id");
    }
    public function DegreeImage()
    {
        return $this->hasOne(Media::class, 'id', 'degree_image');
    }
}
