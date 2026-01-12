<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningLanguageDetail extends Model
{
    use HasFactory;

    protected $fillable = ['learning_language_id', 'language_id', 'name'];

    public $timestamps = false;

    public function learningLanguage()
    {
        return $this->belongsTo(LearningLanguage::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
