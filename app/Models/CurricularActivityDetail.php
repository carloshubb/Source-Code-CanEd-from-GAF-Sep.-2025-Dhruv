<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurricularActivityDetail extends Model
{
    use HasFactory;

    protected $fillable = ["curricular_id", "language_id", "name"];
    public $timestamps = false;
    public function curricularActivity()
    {
        return $this->belongsTo(CurricularActivity::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
