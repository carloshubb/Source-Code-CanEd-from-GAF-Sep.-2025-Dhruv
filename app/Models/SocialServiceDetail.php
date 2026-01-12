<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialServiceDetail extends Model
{
    use HasFactory;

    protected $fillable = ["social_service_id", "language_id", "name"];
    public $timestamps = false;
    public function socialService()
    {
        return $this->belongsTo(SocialService::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
