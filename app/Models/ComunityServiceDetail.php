<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComunityServiceDetail extends Model
{
    use HasFactory;
    protected $fillable = ["comunity_service_id", "language_id", "name"];
    public $timestamps = false;
    public function comunityService()
    {
        return $this->belongsTo(ComunityService::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
