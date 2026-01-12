<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningLanguage extends Model
{
    use HasFactory;
    protected $fillable = ['status'];

    public function learningLanguageDetail()
    {
        return $this->hasMany(LearningLanguageDetail::class, 'learning_language_id', 'id');
    }
}
