<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookieSetting extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function cookieSettingDetail()
    {
        return $this->hasMany(CookieSettingDetail::class, "cookie_setting_id", "id");
    }

}
