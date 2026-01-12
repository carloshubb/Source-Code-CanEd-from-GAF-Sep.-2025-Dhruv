<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarDetail extends Model
{
    use HasFactory;

    protected $fillable = ["webinar_id", "language_code", "agenda", "topic"];
    protected $table = 'webinar_details';
    public $timestamps = false;
    
    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
