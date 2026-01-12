<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityDetail extends Model
{
    use HasFactory;

    protected $fillable = ['activity_id', 'language_id', 'name'];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}