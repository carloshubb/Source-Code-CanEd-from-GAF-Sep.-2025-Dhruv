<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenDayDetail extends Model
{
    use HasFactory;
    protected $fillable = ["open_day_id", "language_code", "title", "description"];
    protected $table = 'open_day_details';
    public $timestamps = false;
    
    public function open_day()
    {
        return $this->belongsTo(OpenDay::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
