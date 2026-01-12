<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqDetail extends Model
{
    use HasFactory;
    protected $fillable = ["faq_id", "language_code", "question", "answer"];
    protected $table = 'faq_details';
    public $timestamps = false;
    
    public function faq()
    {
        return $this->belongsTo(Faq::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
