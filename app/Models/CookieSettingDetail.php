<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookieSettingDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    public function cookieSetting()
    {
        return $this->belongsTo(CookieSetting::class);
    }

}
