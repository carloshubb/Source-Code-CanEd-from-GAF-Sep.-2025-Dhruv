<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurricularActivity extends Model
{
    use HasFactory;
    protected $fillable = ['status'];

    public function curricularActivityDetail()
    {
        return $this->hasMany(CurricularActivityDetail::class, 'curricular_id', 'id');
    }
}
