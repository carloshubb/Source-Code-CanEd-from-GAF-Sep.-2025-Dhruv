<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteDetail extends Model
{
    use HasFactory;
    protected $fillable = ["quote_id", "language_id","quote","slug"];
    public $timestamps = false;


    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
